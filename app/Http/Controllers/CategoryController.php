<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::orderBy('created_at','desc')->get();

            return response()->json($categories, 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'icon' => 'required|mimes:jpg,jpeg,png',
        ]);

        try {
            $category = new Category;
          
            if($request->hasFile('icon')){
                $icon = $request->icon->store('categories');  
            }
            
            $category->name = $request->name;
            $category->icon = $icon;
            $category->save();

            return response()->json(['message' => 'Category added successfully!'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
