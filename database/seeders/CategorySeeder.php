<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();

        // Setările sub forma perechi name-value:
        $categories = [
            ['title' => 'IT News & Trends', 'slug' => 'it-news-trends'],
            ['title' => 'Web Development', 'slug' => 'web-development'],
            ['title' => 'Backend Development', 'slug' => 'backend-development'],
            ['title' => 'Artificial Intelligence & Machine Learning', 'slug' => 'artificial-intelligence-machine-learning'],
            ['title' => 'Cybersecurity', 'slug' => 'cybersecurity'],
            ['title' => 'DevOps & Cloud Computing', 'slug' => 'devops-cloud-computing'],
            ['title' => 'Mobile Development', 'slug' => 'mobile-development'],
            ['title' => 'IT Career & Growth', 'slug' => 'it-career-growth'],
            ['title' => 'Automation & Scripting', 'slug' => 'automation-scripting'],
            ['title' => 'Projects & Open Source', 'slug' => 'projects-open-source'],
        ];
                

        // Inserăm datele în tabelul 'categories'
        DB::table('categories')->insert($categories);
        // Category::factory(6)->create();
    }
}
