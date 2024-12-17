<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\AddCategoryRequest;

class CategoryController extends Controller
{
    public function showCategories() {
        $categories = Category::all()->sortBy('title');
        $title = 'Categorii';
        return view('admin.categories.categories')->with('categories', $categories)->with('title', $title);
    }

    public function newCategoryForm() {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            // abort(403); //Nu vrem să ne afișeze o pagină cu o eroare 403.
            return redirect(route('admin.categories'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }    
        $title = 'Adăugare categorie';
        return view('admin.categories.new-category-form')->with('title', $title);
    }

    public function createNewCategory(AddCategoryRequest $request) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.categories'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }
    
        $request->validate(
            [
                'slug' => 'unique:categories,slug'
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],    
        );

        $category = new Category();
    
        $category->title = $request->title;
        $category->slug = Str::slug($request->slug);
        $category->subtitle = $request->subtitle;
        $category->presentation = $request->presentation;
        $category->position = $request->position;
        $category->published = $request->published;
    
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
    
    public function editCategoryForm($categoryId) {
        $category = Category::findOrFail($categoryId);
        $title = 'Editare categorie';
        return view('admin.categories.edit-category-form')->with('category', $category)->with('title', $title);
    }

    public function updateCategory(AddCategoryRequest $request, $categoryId) {
        $request->validate(
            [
                'slug' => 'unique:categories,slug,' . $categoryId
            ],
            [
                'slug.unique' => 'Acest slug este deja înregistrat!'
            ],        
        );

        $category = Category::findOrFail($categoryId);
    
        $category->title = $request->title;
        $category->slug = Str::slug($request->slug);
        $category->subtitle = $request->subtitle;
        $category->presentation = $request->presentation;
        $category->position = $request->position;
        $category->published = $request->published;
    
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;
        
        if($request->hasFile('image')) {
            if ($category->image != 'category.png') {
                File::delete('storage/images/categories/' . $category->image);
            }
            $photoExtension = $request->file('image')->getClientOriginalExtension();
            $photoName = str_replace(' ', '_', $request->title) . '_' . time() . '.' . $photoExtension;
            $request->file('image')->move('storage/images/categories', $photoName);
    
            $category->image = $photoName;
        }
    
        $confirmationUpdateMessage = "Categoria " . '<strong>' . $request->title . '</strong>' . " a fost actualizată cu succes!";
        
        $category->save();
        
        return redirect(route('admin.categories'))->with('success', $confirmationUpdateMessage);
    }
    
    public function deleteCategory($categoryId) {
        if (! Gate::allows('only-admin-and-author-have-rights')) {
            return redirect(route('admin.categories'))->with('error', 'Nu aveți dreptul să executați această acțiune!');
        }    

        $category = Category::findOrFail($categoryId);

        if ($category->image != 'category.png') {
            File::delete('storage/images/categories/' . $category->image);
        }

        $category->delete();

        return redirect(route('admin.categories'))->with('success', 'Categoria ' . '<strong>' . $category->title . '</strong>' . ' a fost stearsă definitiv din baza de date!');
    }
    
}
