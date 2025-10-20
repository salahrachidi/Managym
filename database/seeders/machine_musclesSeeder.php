<?php

namespace Database\Seeders;

use App\Models\machine_muscle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class machine_musclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        machine_muscle::factory()->count(5)->create();

    }
}
