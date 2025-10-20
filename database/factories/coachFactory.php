<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\coach>
 */
class coachFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'coa_nom'=>fake()->lastName(),
            'coa_prenom'=>fake()->firstName(),
            'coa_email'=>fake()->email(),
            'coa_tele'=>fake()->phoneNumber(),
            'coa_pic'=>fake()->image(),
        ];
    }
}
