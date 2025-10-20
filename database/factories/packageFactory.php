<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\package>
 */
class packageFactory extends Factory
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
        'pac_title'=>fake()->text(5),
        'pac_duree'=>fake()->numberBetween(1,6),
        'pac_description'=>fake()->text(10),
        'pac_prix'=>fake()->numberBetween(100,300),
        ];
    }
}
