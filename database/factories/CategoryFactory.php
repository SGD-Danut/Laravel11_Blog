<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(rand(1, 3), true);
        $slug = Str::slug($title);
    
        return [
            'title' => $title,
            'slug' => $slug,
            'subtitle' => fake()->sentence(rand(4, 8)),
            'presentation' => fake()->paragraphs(rand(1, 3), true),
            'views' => rand(125, 2500),
            'meta_title' => fake()->words(rand(2, 5), true),
            'meta_description' => fake()->words(rand(10, 15), true),
            'meta_keywords' => fake()->words(rand(10, 20), true),
        ];
    }
}
