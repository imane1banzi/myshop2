<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Assure-toi que tu as ce modèle
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Affiche la page de validation de commande.
     */
    public function showCheckout()
    {
        return view('orders.checkout');
    }

    /**
     * Traite la commande et enregistre dans la base.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'total_price' => 'required|numeric',
        ]);

        $order = new Order();
        $order->user_id = Auth::id(); // ou null si pas connecté
        $order->fullname = $request->fullname;
        $order->email = $request->email;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->total_price = $request->total_price;
        $order->cart_data = $request->cart_data; // string JSON
        $order->save();

        return redirect()->route('checkout.success')->with('success', 'Commande validée avec succès !');
    }

    /**
     * Page de confirmation.
     */
    public function success()
    {
        return view('orders.success');
    }
}
