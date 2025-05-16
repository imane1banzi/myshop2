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
        return view('orders.show', compact('order'));
    }
    public function update(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $request->validate([
        'status' => 'required|in:en attente,en cours,livrée,retour,problème',
        'delivery_comment' => 'nullable|string',
    ]);

    $order->update([
        'status' => $request->status,
        'delivery_comment' => $request->delivery_comment,
    ]);

    return redirect()->back()->with('success', 'Commande mise à jour avec succès.');
}

}
