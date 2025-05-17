<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedureSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('procedures')->insert([
            [
                'name' => 'Dental Check-up',
                'description' => 'Routine dental examination and consultation.',
                'cost' => 500.00,
                'duration' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tooth Extraction',
                'description' => 'Removal of a tooth due to decay or damage.',
                'cost' => 1500.00,
                'duration' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Teeth Cleaning',
                'description' => 'Professional cleaning to remove plaque and tartar.',
                'cost' => 800.00,
                'duration' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dental Filling',
                'description' => 'Restoration of tooth structure with filling material.',
                'cost' => 1200.00,
                'duration' => 60,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}