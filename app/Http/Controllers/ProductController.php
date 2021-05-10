<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::orderBy('created_at','desc')->get();
    
            return response()->json($products, 200);
    
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'rent' => 'required',
            'refundable_deposit' => 'required',
            'discount' => 'required',
            'tenure' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png',
        ]);

        try {
            $product = new Product;
          
            if($request->hasFile('image')){
                $image = $request->image->store('products');  
            }
            
            $product->name = $request->name;
            $product->rent = $request->rent;
            $product->refundable_deposit = $request->refundable_deposit;
            $product->discount = $request->discount;
            $product->tenure = $request->tenure;
            $product->image = $image;
            $product->save();

            return response()->json(['message' => 'Product added successfully!'], 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function product_detail($id)
    {
        try {

            $product = Product::with('reviews')->where('id',$id)->first();
           
            $rating = DB::table('ratings')->where('product_id', $id)->avg('rating');

            $product['rating'] = round($rating, 1);

            return response()->json($product, 200);

        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}
