<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, Sortable;

    public $sortable = ['created_at', 'title', 'views'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories() {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id');
    }

    public function publicCategories() {
        return $this->belongsToMany(Category::class, 'category_post', 'post_id', 'category_id')->where('published', 1)->orderBy('title')->get();
    }
    
    public function images() {
        return $this->hasMany(Image::class, 'post_id')->orderBy('position');
    }

    public function publicImages() {
        return $this->hasMany(Image::class, 'post_id')->where('published', 1)->orderBy('position')->paginate(8);
    }
}
