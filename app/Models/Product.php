<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'category', 'image'];

    /** Catégories proposées dans la boutique (filtres) et le formulaire admin. */
    public const CATEGORIES = ['Colliers', 'Bagues', "Boucles d'oreilles"];

    /** Badge « Nouveau » : produit ajouté il y a moins de 30 jours. */
    public const NEW_DAYS = 30;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity', 'price');
    }

    /**
     * URL d'affichage : supporte les images persistantes (images/... commitées
     * dans git, survivent aux redeploys Render) et les uploads storage/
     * (éphémères sur Render free). Fallback visuel fond blanc.
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        return asset('storage/' . $this->image);
    }

    /** Prix formaté : « 249,00 MAD ». */
    public function getPriceLabelAttribute(): string
    {
        return number_format((float) $this->price, 2, ',', ' ') . ' MAD';
    }

    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->gte(now()->subDays(self::NEW_DAYS));
    }
}
