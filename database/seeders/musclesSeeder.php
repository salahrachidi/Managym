<?php

namespace Database\Seeders;

use App\Models\muscle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class musclesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        muscle::factory()->count(5)->create();

    }
}
