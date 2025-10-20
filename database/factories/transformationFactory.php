<?php

namespace Database\Factories;

use App\Models\coach;
use App\Models\personnel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\transformation>
 */
class transformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $per = personnel::all()->count();
        $coa = coach::all()->count();
        return [
            //
            'tra_description' => fake()->text(20),
            'tra_pic1' => fake()->image(),
            'tra_poid' => fake()->numberBetween(50,150),
            'tra_duree' => fake()->numberBetween(1, 8),
            'coach_id' => fake()->numberBetween(1, $coa),
            'personnel_id' => fake()->numberBetween(1, $per),
        ];
    }
}
