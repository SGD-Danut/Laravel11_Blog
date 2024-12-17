<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
}
