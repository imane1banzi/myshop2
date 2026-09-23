<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'image'];
    
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
}
