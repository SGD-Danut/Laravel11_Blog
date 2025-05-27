<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function showAllCategories() {
        $categories = Category::all()->sortBy('title')->sortBy('position')->where('published', '1');
        $title = 'Categorii';
        return view('front.all-categories')->with('categories', $categories)->with('title', $title);
    }

    public function showCurrentCategory(Category $category) {
        if ($category->published == 1) {
            $title = 'Categorie curenta';
            $category->views++;
            $category->save();
            return view('front.current-category')->with('category', $category)->with('title', $title);
        }
        return redirect(route('front.all-categories'));
    }

    public function showAllPosts() {
        if(request('posts')) {
            $posts = Post::where('published_at', '!=', 'null')->orderByDesc('published_at')->paginate(6)->withQueryString();
            return view('front.all-posts')->with('posts', $posts)->with('allPostsTitle', 'Toate postările');
        }

        if(request('author')) {
            $author = User::findOrFail(request('author'));
            $posts = $author->publicPosts();
            return view('front.all-posts')->with('posts', $posts)->with('author', 'Postările autorului: ' . $author->name . ' ');
        }
        
        if (request('searchPostTerm')) {
            $searchPostTerm = request('searchPostTerm');
            $posts = Post::whereNotNull('published_at')
                ->where(function ($query) use ($searchPostTerm) {
                    return $query
                    ->where('title', 'LIKE', "%{$searchPostTerm}%")
                    ->orWhere('subtitle', 'LIKE', "%{$searchPostTerm}%")
                    ->orWhere('presentation', 'LIKE', "%{$searchPostTerm}%");
                })
                ->orderByDesc('published_at')
                ->paginate(6)
                ->withQueryString();
            return view('front.all-posts')->with('posts', $posts)->with('searchPostTerm', 'Articole găsite pentru: ' . $searchPostTerm);
        }    
    }
    
    public function showCurrentPost(Post $post) {
        $post->views++;
        $post->save();
        $title = 'Postări';
        return view('front.current-post')->with('post', $post)->with('title', $title);
    }
}
