<?php
namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        $promoCodes = PromoCode::all();
        return view('promo_codes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('promo_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:promo_codes,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        PromoCode::create($request->all());

        return redirect()->route('promo_codes.index')->with('success', 'Code promo ajouté avec succès.');
    }

    public function edit(PromoCode $promoCode)
    {
        return view('promo_codes.edit', compact('promoCode'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $request->validate([
            'code' => 'required|unique:promo_codes,code,' . $promoCode->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
        ]);

        $promoCode->update($request->all());

        return redirect()->route('promo_codes.index')->with('success', 'Code promo mis à jour.');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return redirect()->route('promo_codes.index')->with('success', 'Code promo supprimé.');
    }
}
