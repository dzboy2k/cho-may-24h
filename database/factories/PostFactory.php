<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Status;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $brandId = Brand::inRandomOrder()->first()->id;
        $categoryId = Category::inRandomOrder()->first()->id;
        $statusId = Status::inRandomOrder()->first()->id;
        $providerId = Provider::inRandomOrder()->first()->id;
        $price = $this->faker->numberBetween(10000000, 100000000);
        $limit_month = $this->faker->numberBetween(1, 12);
        $support_limit = $this->faker->numberBetween($price / 2, $price);
        $support_receive = $support_limit / $limit_month / 30;
        return [
            'author_id' => User::first()->id,
            'category_id' => $categoryId,
            'status_id' => $statusId,
            'brand_id' => $brandId,
            'is_partner' => $this->faker->numberBetween(0, 1),
            'provider_id' => $providerId,
            'title' => $this->faker->sentence,
            'addition_info' => $this->faker->text(),
            'is_official' => $this->faker->boolean,
            'price' => $price,
            'support_limit' => $support_limit,
            'receive_support' => $support_receive,
            'expire_limit_month' => $limit_month,
            'description' => $this->faker->text(),
            'amount_view' => $this->faker->randomNumber(),
            'post_state' => $this->faker->boolean,
            'slug' => $this->faker->slug,
            'release_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Post $post) {
            \DB::table('posts_images')->insert([
                'post_id' => $post->id,
                'image_id' => 1,
            ]);
        });
    }
}
