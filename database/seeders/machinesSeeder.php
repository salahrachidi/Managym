<?php

namespace Database\Seeders;

use App\Models\machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class machinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        machine::factory()->count(5)->create();
    }
}
