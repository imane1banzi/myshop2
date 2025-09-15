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
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    // Mise à jour des informations de la commande
    $order->update([
        'fullname' => $request->fullname,
        'email' => $request->email,
        'address' => $request->address,
        'phone' => $request->phone,
        'status' => $request->status,
        'delivery_comment' => $request->delivery_comment,
    ]);

    // Supprimer tous les items existants pour les remplacer par les nouveaux
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

    // Mettre à jour le total de la commande
    $order->total_price = $totalPrice;
    $order->save();

    return redirect()->back()->with('success', 'Commande mise à jour avec succès.');
}



}
