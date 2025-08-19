<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Verificar y crear roles si no existen
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);
        


        // Asignar rol admin al usuario principal
        $user = User::where('email', 'admin@example.com')->first();
        if ($user && !$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        // Asignar rol admin al usuario principal
        $user3 = User::where('email', 'guillebermejo1@gmail.com')->first();
        if ($user3 && !$user3->hasRole('admin')) {
            $user3->assignRole('admin');
        }
    
        $user4 = User::where('email', 'mariana.andino@hospital.uncu.edu.ar')->first();
        if ($user4 && !$user4->hasRole('admin')) {
            $user4->assignRole('admin');
        }
    
    }

}
