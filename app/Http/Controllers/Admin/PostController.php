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
        $postsStatus = null;

        if (request('author')) {
            $posts = Post::where('user_id', request('author'))->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $authorName = User::findOrFail(request('author'))->name;
        } else {
            $posts = Post::sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
        }

        $title = 'Postări';

        if (request('published') == 'public') {
            $posts = Post::where('published_at', '<>', null)->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $postsStatus = "publicate";
        }
    
        if (request('published') == 'private') {
            $posts = Post::where('published_at', null)->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
            $postsStatus = "nepublicate";
        }

        return view('admin.posts.posts')->with('posts', $posts)->with('title', $title)->with('authorName', $authorName)->with('postsStatus', $postsStatus);
    }
}
