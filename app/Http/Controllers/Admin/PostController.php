<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PostController extends Controller
{
    public function showPosts() {
        $authorName = null;
        if (request('author')) {
            $posts = Post::where('user_id', request('author'))->orderByDesc('created_at')->paginate(6);
            $authorName = User::findOrFail(request('author'))->name;
        } else {
            $posts = Post::orderByDesc('created_at')->paginate(6);
        }

        $title = 'Postări';
        
        return view('admin.posts.posts')->with('posts', $posts)->with('title', $title)->with('authorName', $authorName);
    }
}
