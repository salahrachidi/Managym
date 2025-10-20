<?php

namespace Database\Factories;

use App\Models\personnel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\payment>
 */
class paymentFactory extends Factory
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
        'personnel_id'=>fake()->numberBetween(1,$per),
        ];
    }
}
