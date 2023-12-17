<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request){


        $products = DB::table('products')
        ->when($request->input('name'), function($query,$name){
            return $query->where('name','like','%'.$name.'%');
        })
        ->orderBy('created_at','desc')
        ->paginate(10);

        return view('pages.products.index', compact('products'));
    }

    public function create(){
        return view('pages.products.create');
    }

    public function store(Request $request){
        $data = $request->all();
        // $data['password'] = Hash::make($request->password);
        \App\Models\Product::create($data);

        return redirect()->route('product.index')->with('success','Product Successfully Added');
    }

    public function edit($id){
        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product){
        // $data = $request->validated();
        $data = $request->all();
        // $data['password'] = Hash::make($request->password);
        // $user = \App\Models\User::findOrFail($id);
        $product->update($data);

        return redirect()->route('product.index')->with('success','Product Successfully Updated');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('product.index')->with('success','Product Successfully Deleted');
    }


}
