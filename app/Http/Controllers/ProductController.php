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

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
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

        // Handle image upload and replacement
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Upload new image
            $imagePath = $request->file('image')->store('product_images', 'public');
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
        // Delete the product image from storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

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
