<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;

class CategoryController extends Controller
{
    public function showCategories() {
        $categories = Category::all()->sortBy('title');
        $title = 'Categorii';
        return view('admin.categories.categories')->with('categories', $categories)->with('title', $title);
    }

    public function newCategoryForm() {
        $title = 'Adăugare categorie';
        return view('admin.categories.new-category-form')->with('title', $title);
    }

    public function createNewCategory(AddCategoryRequest $request) {
        $category = new Category();
    
        $category->title = $request->title;
        $category->slug = Str::slug($request->slug);
        $category->subtitle = $request->subtitle;
        $category->presentation = $request->presentation;
    
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        
        if ($request->hasFile('image')) {
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('storage/images/categories', $photoName);
    
            $category->image = $photoName;
        }
    
        $confirmationUpdateMessage = "Categoria " . $request->title . " a fost adăugată cu succes!";
        
        $category->save();
        
        return redirect(route('admin.categories'))->with('success', $confirmationUpdateMessage);
    }
    
}
