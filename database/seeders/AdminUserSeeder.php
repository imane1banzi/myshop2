<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * SEULE méthode officielle pour créer un admin.
     * Pas de route, pas de formulaire : lancer en ligne de commande.
     *   php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@myshop.ma'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Admin123!'),
                'role' => 'admin',
            ]
        );
    }
}
