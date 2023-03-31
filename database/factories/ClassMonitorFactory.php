<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\FactoryHelper;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassMonitor>
 */
class ClassMonitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cm_id' => FactoryHelper::getRandomModelId(Student::class),
            'for_grade' => $this->faker->numberBetween(1,12),
            'from_date'=>$this->faker->date(),
            'to_date'=>null,

        ];
    }
}
