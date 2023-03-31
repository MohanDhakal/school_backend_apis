<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\FactoryHelper;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'staff_id' => FactoryHelper::getRandomModelId(Staff::class),
            'subject_name'=>$this->faker->word(),
            'of_grade' => $this->faker->numberBetween(1,12),
        ];
    }
}
