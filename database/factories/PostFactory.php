<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
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
    public function definition(): array
    {
        $title = fake()->words(rand(1,3), true);
        $slug = Str::slug($title);
        $randomDate2YearsAgoAndNow = fake()->dateTimeBetween('-2 years', 'now');

        return [
            'title' => $title,
            'slug' => $slug,
            'subtitle' => fake()->sentence(rand(4, 8)),
            'image' => 'post.png',
            'presentation' => fake()->paragraphs(rand(1, 3), true),
            'content' => fake()->paragraphs(rand(6, 12), true),
            'views' => rand(125, 2500),
            'published_at' => fake()->randomElement(array(null, $randomDate2YearsAgoAndNow)),
            'user_id' => User::all()->where('role', 'author')->random(),

            'meta_title' => fake()->words(rand(2, 5), true),
            'meta_description' => fake()->words(rand(10, 15), true),
            'meta_keywords' => fake()->words(rand(10, 20), true),

            'created_at' => $randomDate2YearsAgoAndNow
        ];
    }
}
