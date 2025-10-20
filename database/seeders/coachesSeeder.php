<?php

namespace Database\Seeders;

use App\Models\coach;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class coachesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        coach::factory()->count(5)->create();

    }
}
