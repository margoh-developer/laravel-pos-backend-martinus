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

        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category'  => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            // 'is_best_seller' => 'required|boolean',
        ]);
        $filename = time().'.'.$request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product = new \App\Models\Product;
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = (int) $data['price'];
        $product->stock = (int) $data['stock'];
        $product->category = $data['category'];
        if (isset($data['is_best_seller'])) {
            $product->is_best_seller = $data['is_best_seller'];
        }
        // $product->is_best_seller = $data['is_best_seller'];
        $product->image = $filename;
        $product->save();
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

        // $request->validate([
        //     'name' => 'required|min:3|unique:products',
        //     'price' => 'required|integer',
        //     'stock' => 'required|integer',
        //     'category'  => 'required|in:food,drink,snack',
        //     'image' => 'required|image|mimes:jpeg,png,jpg',
        // ]);

        // $filename = time().'.'.$request->image->extension();
        // $request->image->storeAs('public/products', $filename);

        $data = $request->all();


        $product->update($data);

        if ($request->hasFile('image')) {
            //delete existing image
            if ($product->image) {
                $image_path = public_path('storage/products/'.$product->image);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $filename = time().'.'.$request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $product->image = $filename;
        }
        // $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success','Product Successfully Updated');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('product.index')->with('success','Product Successfully Deleted');
    }


}
