<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function imageUrl() {
        return asset('storage/images/post-images/' . $this->post_id . '/' . $this->file);
    }

    public function filePath() {
        return public_path('storage/images/post-images/' . $this->post_id . '/' . $this->file);
    }
}
