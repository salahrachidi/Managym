<?php

namespace Database\Seeders;

use App\Models\personnel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class personnelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        personnel::factory()->count(1)->create();
    }
}
