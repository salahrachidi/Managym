<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\machine>
 */
class machineFactory extends Factory
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
        'mac_label'=>fake()->text(10),
        'mac_description'=>fake()->text(30),
        'mac_pic'=>fake()->text(7),
        'mac_matricule'=>fake()->text(5),
        ];
    }
}
