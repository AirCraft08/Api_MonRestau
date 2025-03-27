<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Exécuter le seeder.
     *
     * @return void
     */
    public function run()
    {
        // Vérifie si un utilisateur admin existe déjà pour ne pas dupliquer
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password123'),  // Assure-toi de choisir un mot de passe sécurisé
                'role' => 'admin',  // Attribue le rôle "admin"
            ]);
        }
    }
}
