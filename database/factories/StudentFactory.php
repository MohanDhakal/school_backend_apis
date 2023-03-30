<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'full_name' => fake()->name(),
            'dob'=>fake()->date(),
            'grade'=>fake()->numberBetween(1,12),            
            'email' => fake()->unique()->safeEmail(),
            'address'=>fake()->address(),
            'guardian_contact'=>fake()->phoneNumber(),
            'image_uri'=>fake()->text(100),
            'current_rank'=>fake()->numberBetween(0,20),
            'roll_number'=>fake()->numberBetween(0,20),
            'major_subject'=>"Optional Maths",
            'joined_at' =>fake()->date(), 
            'is_active'=>fake()->boolean(),
        ];
    }
}
