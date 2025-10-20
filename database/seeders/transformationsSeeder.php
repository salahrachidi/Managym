<?php

namespace Database\Seeders;

use App\Models\transformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class transformationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        transformation::factory()->count(5)->create();
    }
}
