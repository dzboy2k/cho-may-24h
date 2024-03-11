<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $author_id = User::inRandomOrder()->first()->id;
        return [
            'author_id' => $author_id,
            'title' => $this->faker->title(),
            'slug' => $this->faker->unique()->slug(),
            'body' => $this->faker->text(10000),
            'meta_description' => $this->faker->text(500),
            'show_in_home_slide' => 1,
            'show_in_header' => $this->faker->numberBetween(0, 1),
            'is_service' => 0,
            'image' => 'images/default-slide.png',
            'status' => 'ACTIVE'
        ];
    }
}
