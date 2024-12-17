<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function showAllCategories() {
        $categories = Category::all()->sortBy('title');
        $title = 'Categorii';
        return view('front.all-categories')->with('categories', $categories)->with('title', $title);
    }

    public function showCurrentCategory(Category $category) {
        $title = 'Categorie curenta';
        $category->views++;
        $category->save();
        return view('front.current-category')->with('category', $category)->with('title', $title);
    }
}
