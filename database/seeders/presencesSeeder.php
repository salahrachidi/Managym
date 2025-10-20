<?php

namespace Database\Seeders;

use App\Models\presence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class presencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        presence::factory()->count(5)->create();
    }
}
