<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Dossiers web réels où écrire les images.
     * Local/XAMPP : public_path() suffit.
     * Hostinger : projet dans myshop2/ mais docroot = public_html/ (voisin),
     * donc on écrit aux 2 endroits pour que l'URL /images/produits/... réponde en 200.
     */
    private function webImageDirs(): array
    {
        $dirs = [public_path('images/produits')];

        $candidates = [];
        // Frère de base_path() : ~/public_html (cas myshop2/ + public_html/ voisins)
        $candidates[] = dirname(base_path()) . '/public_html/images/produits';
        // DOCUMENT_ROOT réel du serveur web
        if (!empty($_SERVER['DOCUMENT_ROOT'])) {
            $candidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/images/produits';
        }

        foreach ($candidates as $dir) {
            // Évite les doublons (même dossier via symlink)
            $already = false;
            foreach ($dirs as $existing) {
                if (realpath($dir) && realpath($existing) && realpath($dir) === realpath($existing)) {
                    $already = true;
                    break;
                }
                if (rtrim($dir, '/\\') === rtrim($existing, '/\\')) {
                    $already = true;
                    break;
                }
            }
            if (!$already) {
                $dirs[] = $dir;
            }
        }

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
        }

        return $dirs;
    }

    /** Déplace l'upload vers le 1er dossier web puis le recopie vers les autres (Hostinger). */
    private function saveUploadedImage($file): string
    {
        $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
        $dirs = $this->webImageDirs();
        $file->move($dirs[0], $filename);
        foreach (array_slice($dirs, 1) as $mirror) {
            if (is_dir($mirror)) {
                @copy($dirs[0] . '/' . $filename, rtrim($mirror, '/\\') . '/' . $filename);
            }
        }
        return 'images/produits/' . $filename;
    }

    /** Supprime l'image aux 2 emplacements web + ancien storage/ pour compat. */
    private function deleteImageFile(?string $imagePath): void
    {
        if (!$imagePath) {
            return;
        }
        if (str_starts_with($imagePath, 'images/')) {
            $candidates = [public_path($imagePath)];
            $candidates[] = dirname(base_path()) . '/public_html/' . $imagePath;
            if (!empty($_SERVER['DOCUMENT_ROOT'])) {
                $candidates[] = rtrim($_SERVER['DOCUMENT_ROOT'], '/\\') . '/' . $imagePath;
            }
            foreach (array_unique($candidates) as $full) {
                if (file_exists($full)) {
                    @unlink($full);
                }
            }
        } else {
            Storage::disk('public')->delete($imagePath);
        }
    }
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ]);

        // Handle image upload (dossier public direct : pas de storage:link requis sur Hostinger)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->saveUploadedImage($request->file('image'));
        }

        // Create a new product
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        // Redirect to the product list
        return redirect()->route('products.index');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
        ]);

        // Handle image upload and replacement (public/images/produits : compatible Hostinger sans symlink)
        if ($request->hasFile('image')) {
            // Delete the old image if it exists (web mirrors + ancien chemin storage/)
            $this->deleteImageFile($product->image);

            // Upload new image (écrit public/ + miroir public_html/)
            $imagePath = $this->saveUploadedImage($request->file('image'));
        } else {
            // Keep the current image
            $imagePath = $product->image;
        }

        // Update the product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
        ]);

        // Redirect to the product list
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified product from the database.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Delete the product image (miroirs web + ancien storage/ pour compat)
        $this->deleteImageFile($product->image);

        // Delete the product
        $product->delete();

        // Redirect to the product list
        return redirect()->route('products.index');
    }
   public function popularItems()
{
    // Récupérer les produits les plus vendus via la table order_items
    $popularProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->with('product') // Si relation définie
        ->take(10)
        ->get();

    return view('products.popular', compact('popularProducts'));
}
public function newArrivals(Request $request)
{
    // Nombre de produits par page (5 par défaut)
    $perPage = $request->get('per_page', 5);

    // Sécurité : valeurs autorisées
    if (!in_array($perPage, [5, 10, 15])) {
        $perPage = 5;
    }

    $newArrivals = Product::orderBy('created_at', 'desc')
        ->paginate($perPage)
        ->withQueryString(); // garde les paramètres dans la pagination

    return view('products.new-arrivals', compact('newArrivals', 'perPage'));
}
}
