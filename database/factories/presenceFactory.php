<?php

namespace Database\Factories;

use App\Models\personnel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\presence>
 */
class presenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $per = personnel::all()->count();

        return [
        //
        // 'pre_date'=>fake()->date(),
        // 'pre_time'=>fake()->time(),
        'personnel_id'=>fake()->numberBetween(1,$per),
        ];
    }
}
