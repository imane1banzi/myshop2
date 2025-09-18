<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

   public function show($id)
{
    $order = Order::with('items')->findOrFail($id);
    $products = \App\Models\Product::all(); // <-- liste des produits disponibles

    return view('orders.show', compact('order', 'products'));
}
public function update(Request $request, $id)
{
    $order = Order::with('items')->findOrFail($id);

    $request->validate([
        'fullname' => 'required|string|max:255',
        'email' => 'required|email',
        'address' => 'required|string|max:500',
        'phone' => 'required|string|max:20',
        'status' => 'required|in:en attente,en cours,livrée,retour,problème',
        'delivery_comment' => 'nullable|string',
        'items' => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'coupon_code' => 'nullable|string|max:50',
    ]);

    // Mise à jour des informations de la commande
    $order->update([
        'fullname' => $request->fullname,
        'email' => $request->email,
        'address' => $request->address,
        'phone' => $request->phone,
        'status' => $request->status,
        'delivery_comment' => $request->delivery_comment,
        'coupon_code' => $request->coupon_code, // on enregistre directement le code
    ]);

    // Supprimer tous les items existants
    $order->items()->delete();

    $totalPrice = 0;

    foreach ($request->items as $itemData) {
        $product = \App\Models\Product::find($itemData['product_id']);
        if (!$product) continue;

        $subtotal = $product->price * $itemData['quantity'];
        $totalPrice += $subtotal;

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'quantity' => $itemData['quantity'],
        ]);
    }

    // --- Gestion du code promo ---
    $discountAmount = 0;
    if ($request->coupon_code) {
        $validCodes = [
            'PROMO10' => 0.10, // 10% de remise
            'PROMO20' => 0.20, // 20% de remise
        ];

        $code = strtoupper($request->coupon_code);
        if (array_key_exists($code, $validCodes)) {
            $discountAmount = $totalPrice * $validCodes[$code];
        } else {
            return redirect()->back()->withErrors(['coupon_code' => 'Code promo invalide.']);
        }
    }

    // Mettre à jour le total final et le montant de la remise
    $order->discount_amount = $discountAmount;
    $order->total_price = $totalPrice - $discountAmount;
    $order->save();

    return redirect()->back()->with('success', 'Commande mise à jour avec succès.');
}





}
