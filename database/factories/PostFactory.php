<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Helpers\FactoryHelper;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'=>$this->faker->word,
            'body'=>[$this->faker->paragraph()],
            'cover_image'=>$this->faker->imageUrl(),
            'user_id' => FactoryHelper::getRandomModelId(User::class),
        ];
    }
}
