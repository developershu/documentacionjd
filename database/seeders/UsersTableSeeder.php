<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder 
{

public function run()
{
    $users = [
        ['name' => 'Mariana Andino', 'email' => 'mariana.andino@hospital.uncu.edu.ar', 'role' => 'admin'],
        ['name' => 'Conrado Risso Patrón', 'email' => 'conrado@rissopatron.com.ar', 'role' => 'user'],
        ['name' => 'Walter Frajberg', 'email' => 'walter.frajberg@hospital.uncu.edu.ar', 'role' => 'user'],
        ['name' => 'Adolfo Gustavo Cívico', 'email' => 'adolfo.civico@hospital.uncu.edu.ar', 'role' => 'user'],
        ['name' => 'Gonzalo Nalda', 'email' => 'gonzalo.nalda@hospital.uncu.edu.ar', 'role' => 'user'],
        ['name' => 'Matias Papini', 'email' => 'matias.papini@hospital.uncu.edu.ar', 'role' => 'user'],
        ['name' => 'Silvana Pagliarulo', 'email' => 'silvana.pagliarulo@hospital.uncu.edu.ar', 'role' => 'user'],
        ['name' => 'Cinthia Chaparro', 'email' => 'cinthia.chaparro@hospital.uncu.edu.ar', 'role' => 'user'],
        
    ];

    foreach ($users as $userData) {
        DB::table('users')->insert([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make('hospital.2025'),
            'role' => $userData['role'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
}

