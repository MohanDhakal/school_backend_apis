<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\FactoryHelper;
use App\Models\Staff;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassTeacher>
 */
class ClassTeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ct_id' => FactoryHelper::getRandomModelId(Staff::class),
            'for_grade' => $this->faker->numberBetween(1,12),
            'from_date'=>$this->faker->date(),
            'to_date'=>null,

        ];
    }
}
