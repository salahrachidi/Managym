<?php

namespace Database\Factories;

use App\Models\machine;
use App\Models\muscle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\machine_muscle>
 */
class machine_muscleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mus = muscle::all()->count();
        $mac = machine::all()->count();

        return [
        //
        'machine_id'=>fake()->numberBetween(1,$mac),
        'muscle_id'=>fake()->numberBetween(1,$mus),
        ];
    }
}
