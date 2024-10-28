<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
{
    $products = Product::all(); // Fetch all products
    return view('welcomepage', compact('products')); // Pass products to the 'welcomepage' view
}
}
