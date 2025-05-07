<?php
namespace App\Http\Controllers;
use App\Models\Product;

class CartController extends Controller
{
    public function showCart()
    {
        $products = Product::all();
        return view('orders.cart', compact('products'));
    }
}
