<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //all product

        $products= \App\Models\Product::orderBy('id','desc')->get();
        return response()->json([
            'success' => true,
            'message'=> 'List Data Product',
            'data'=> $products,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'is_best_seller' => 'required|boolean',

        ]);

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $product = \App\Models\Product::create([
            'name' => $request->name,
            'price' => (int) $request->price,
            'stock' => (int) $request->stock,
            'category' => $request->category,
            'image' => $filename,
            // 'is_favorite' => $request->is_favorite,
            'is_best_seller' => $request->is_best_seller,
       

        ]);

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Failed to Save',
            ], 409);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = \App\Models\Product::findOrFail($id);

        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'is_best_seller' => 'required|boolean',
        ]);

        // Update the product attributes
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category = $request->category;

        // Uncomment this block if you want to update the image as well
        if ($request->hasFile('image')) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);

            // Delete the old image from storage
            Storage::delete('public/products/' . $product->image);

            $product->image = $filename;
        }

        $product->is_best_seller = $request->is_best_seller;
        $product->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Product Updated',
        //     'data' => $product
        // ], 201);

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Product Created',
                'data' => $product
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Failed to Save',
            ], 409);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete product and product image from storage
        $product = \App\Models\Product::findOrFail($id);

        // Delete the product image from storage
        Storage::delete('public/products/' . $product->image);

        // Delete the product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product Deleted',
        ], 200);

    }
}
