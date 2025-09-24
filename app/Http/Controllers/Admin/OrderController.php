<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;

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
        $products = Product::all();
        $promoCodes = PromoCode::all(); // 🔹 récupérer tous les codes promo

        return view('orders.show', compact('order', 'products', 'promoCodes'));
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

        // Mise à jour des infos de la commande
        $order->update([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => $request->status,
            'delivery_comment' => $request->delivery_comment,
            'coupon_code' => $request->coupon_code,
        ]);

        // Supprimer tous les anciens items
        $order->items()->delete();

        $totalPrice = 0;

        foreach ($request->items as $itemData) {
            $product = Product::find($itemData['product_id']);
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

        // --- Vérifier le code promo depuis la DB ---
        $discountAmount = 0;
        if ($request->coupon_code) {
            $promo = PromoCode::where('code', $request->coupon_code)
                ->where(function ($q) {
                    $q->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
                })
                ->first();

            if ($promo) {
                if ($promo->type === 'percent') {
                    $discountAmount = $totalPrice * ($promo->value / 100);
                } elseif ($promo->type === 'fixed') {
                    $discountAmount = $promo->value;
                }
            } else {
                return redirect()->back()->withErrors(['coupon_code' => 'Code promo invalide ou expiré.']);
            }
        }

        // Mettre à jour le total et la remise
        $order->discount_amount = $discountAmount;
        $order->total_price = $totalPrice - $discountAmount;
        $order->save();

        return redirect()->back()->with('success', 'Commande mise à jour avec succès.');
    }
}
