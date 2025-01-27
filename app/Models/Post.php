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
}
