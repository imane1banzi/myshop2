<?php
namespace App\Http\Controllers;

class CartController extends Controller
{
    /** Page panier : rendue côté client depuis le localStorage (public/js/cart.js). */
    public function showCart()
    {
        return view('orders.cart');
    }
}
