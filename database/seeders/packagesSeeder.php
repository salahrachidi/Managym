<?php

namespace Database\Seeders;

use App\Models\package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class packagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        package::factory()->count(5)->create();

    }
}
