<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    public function posts() {
        return $this->belongsToMany(Post::class, 'category_post', 'category_id', 'post_id');
    }

    public function publicPosts() {
        return $this->belongsToMany(Post::class, 'category_post', 'category_id', 'post_id')->where('published_at', '!=', NULL)->orderByDesc('published_at')->paginate(6)->withQueryString();
    }        
}
