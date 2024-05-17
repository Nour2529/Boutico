<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function getImageurl($id)
    {
        // Retrieve the Product by ID
        $product = Product::find($id);

        // Check if the Product exists
        if ($product) {
            // Assuming you have an 'image' column in your Product model
            $imagePath = $product->image;

            // Return the image path
            return response()->json($imagePath);
        }

        // Return a default image
        return response()->json('images/default.png');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'marque_id' => 'required|exists:marques,id',
            'stock' => 'required|integer',
            'part_number' => 'string|max:255|unique:products',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = new Product;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->marque_id = $request->input('marque_id');
        $product->stock = $request->input('stock');
        $product->part_number = $request->input('part_number');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $filename);
            $product->image = $filename;
        }

        $product->save();


        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'category_id' => 'exists:categories,id',
            'marque_id' => 'exists:marques,id',
            'stock' => 'integer',
            'part_number' => 'string|max:255|unique:products',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->marque_id = $request->input('marque_id');
        $product->stock = $request->input('stock');
        $product->part_number = $request->input('part_number');


        $product->update();

        return response()->json($product, 200);
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer'
        ]);

        $product = Product::findOrFail($id);
        $stock = $request->input('stock');
        $stockAncien = $product->stock;
        $product->stock = $stockAncien - $stock;

        $product->update();

        return response()->json($product, 200);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(null, 204);
    }
}
