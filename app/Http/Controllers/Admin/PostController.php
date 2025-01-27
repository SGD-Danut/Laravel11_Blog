<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\AddPostRequest;

class PostController extends Controller
{
    public function showPosts() {
        $authorName = null;
        $postsStatus = null;
        $searchedPost = null;

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

        if (request('searchPostTerm')) {
            $searchedPost = request('searchPostTerm');
            $posts = Post::where('title', 'LIKE', "%{$searchedPost}%")->orWhere('meta_description', 'LIKE', "%{$searchedPost}%")->sortable(['created_at' => 'desc'])->paginate(6)->withQueryString();
        }    

        return view('admin.posts.posts')->with('posts', $posts)->with('title', $title)->with('authorName', $authorName)->with('postsStatus', $postsStatus)->with('searchedPost', $searchedPost);
    }

    public function newPostForm() {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.posts'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }
        
        $authors = null;
        $title = 'Adăugare postare';

        if (auth()->user()->role == 'admin') {
            $authors = User::select('id', 'name')->where('role', 'author')->orderBy('name')->get();
        }

        return view('admin.posts.new-post-form')->with('title', $title)->with('authors', $authors);
    }

    public function createNewPost(AddPostRequest $request) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.posts'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }

        $request->validate(
            [
                'slug' => 'unique:posts,slug'
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ]    
        );

        $post = new Post;

        $post->title = $request->title;
        $post->slug = Str::slug($request->slug);
        $post->subtitle = $request->subtitle;
        $post->presentation = $request->presentation;
        $post->content = $request->content;
        
        if ($request->published == 1) {
            $post->published_at = $request->published_at;
        }
        
        if(auth()->user()->role == 'author') {
            $post->user_id = auth()->id();
        }
        
        if(auth()->user()->role == 'admin') {
            $post->user_id = $request->post_author;
        }

        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('storage/images/posts', $photoName);

            $post->image = $photoName;
        }

        $confirmationAddMessage = "Postarea " . '<strong>' . $request->title . '</strong>' . " a fost adăugată cu succes!";
        
        $post->save();
        
        return redirect(route('admin.posts'))->with('success', $confirmationAddMessage);
    }

    public function editPostForm($postId) {
        $authors = null;
        $title = 'Editare postare';
        $post = Post::findOrFail($postId);

        if (auth()->user()->role == 'admin') {
            $authors = User::select('id', 'name')->where('role', 'author')->orderBy('name')->get();
        }

        return view('admin.posts.edit-post-form')->with('post', $post)->with('authors', $authors)->with('title', $title);   
    }

    public function updatePost(AddPostRequest $request, $postId) {
        $request->validate(
            [
                'slug' => 'unique:posts,slug,' . $postId
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],        
        );

        $post = Post::findOrFail($postId);

        $post->title = $request->title;
        $post->slug = Str::slug($request->slug);
        $post->subtitle = $request->subtitle;
        $post->presentation = $request->presentation;
        $post->content = $request->content;
        //Dacă avem bifat butonul Public, să se adauge data publicării:
        if ($request->published == 1) {
            $post->published_at = $request->published_at;
        } else {
            $post->published_at = null;
        }
        //Dacă utilizatorul autentificat are rolul de admin, coloana user_id va fi ocupată cu id-ul utilizatorului cu rol de author selectat de Administrator:
        if(auth()->user()->role == 'admin') {
            $post->user_id = $request->post_author;
        }
    
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            if ($post->image != 'post.png') {
                File::delete('storage/images/posts/' . $post->image);
            }
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('storage/images/posts', $photoName);
    
            $post->image = $photoName;
        }
    
        $confirmationUpdateMessage = "Postarea " . '<strong>' . $request->title . '</strong>' . " a fost actualizată cu succes!";
        
        $post->save();
        
        return redirect(route('admin.posts'))->with('success', $confirmationUpdateMessage);    
    }
}
