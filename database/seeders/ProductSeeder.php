<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Catalogue de base avec images PERSISTANTES (public/images/produits/,
     * commitées dans git, présentes dans l'image Docker).
     * updateOrCreate = réparable à chaque deploy sans doublons.
     */
    public function run(): void
    {
        Product::updateOrCreate(
            ['name' => 'Bague Torsadee Or'],
            [
                'description' => 'Bague torsadee en plaqué or sertie de zircons. Finition brillante.',
                'price' => 299.00,
                'image' => 'images/produits/bague-torsadee-or.png',
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Collier Chaine Doree'],
            [
                'description' => 'Collier chaine en plaqué or avec pendantif zircon. Fermoir sécurisé.',
                'price' => 249.00,
                'image' => 'images/produits/collier-or-zircon.png',
            ]
        );

        Product::updateOrCreate(
            ['name' => 'Collier Minimaliste Doré 18K'],
            [
                'description' => "Collier délicat au design minimaliste, parfait pour compléter une tenue quotidienne ou élégante. Sa chaîne fine et sa finition dorée offrent un style discret et moderne.",
                'price' => 299.00,
                'image' => 'images/produits/collier-minimaliste-dore-18k.jpg',
            ]
        );
    }
}
