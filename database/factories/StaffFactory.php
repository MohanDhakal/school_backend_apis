<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
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
            'level'=>"प्राथमिक तह",
            'email' => fake()->unique()->safeEmail(),
            'address'=>fake()->address(),
            'phone_number'=>fake()->phoneNumber(),
            'image_uri'=>fake()->imageUrl(),
            'post'=>"Teacher",
            'rank'=>1,
            'major_in'=>"Mathematics",
            'joined_at' =>fake()->date(), // password
            'job_type' => "स्थायी",
            'is_active'=>fake()->boolean(),
        ];
    }
}
