<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function index(){
        $products = Product::orderby('created_at')->get();
        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2028'
        ]);

        $product = New Product;

        $file_name = time(). '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $file_name);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->image = $file_name;
        $product->category = $request->category;
        $product->price = $request->price;


        $product->save();
        return redirect()->route('products.index')->with('success', 'Product Added Successfully');
    }
}
