<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrator with full access'],
            ['name' => 'dentist', 'description' => 'Dentist with clinical access'],
            ['name' => 'receptionist', 'description' => 'Receptionist with patient management access']
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
