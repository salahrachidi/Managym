<?php

namespace Database\Factories;

use App\Models\coach;
use App\Models\package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\personnel>
 */
class personnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pac = package::all()->count();
        $coa = coach::all()->count();
        $arr = ['H','F'];
        $i = fake()->numberBetween(0,1);
        return [
        //
        'per_role'=>fake()->boolean(),
        'per_nom'=>fake()->lastName(),
        'per_prenom'=>fake()->firstName(),
        'per_tel'=>fake()->phoneNumber(),
        'per_pic'=>fake()->image(),
        'per_sexe'=>$arr[$i],
        'per_email'=>fake()->email(),
        'per_password'=>fake()->password(),
        'per_status'=>fake()->boolean(),
        'package_id'=>fake()->numberBetween(1,$pac),
        'coach_id'=>fake()->numberBetween(1,$coa),
        ];
    }
}
