<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marques = Marque::all();
        return response()->json($marques);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:marques',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $image = request()->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);

        $marque = new Marque;
        $marque->name = $request->input('name');
        $marque->image = $imageName;

        $marque->save();

        return response()->json($marque, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marque = Marque::findOrFail($id);
        return response()->json($marque);
    }

    public function getImageUrl($id)
    {
        // Retrieve the Marque by ID
        $marque = Marque::find($id);

        // Check if the Marque exists
        if ($marque) {
            // Assuming you have an 'image' column in your Marque model
            $imagePath = $marque->image;

            // Assuming your images are stored in the public/images folder
            $imageUrl = asset("images/{$imagePath}");

            return $imageUrl;
        }

        // Return a default image URL or handle the case when Marque is not found
        return asset("images/default.png");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255|unique:marques'
        ]);

        $marque = Marque::findOrFail($id);
        $marque->update($request->all());

        return response()->json($marque, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marque = Marque::findOrFail($id);
        $marque->delete();

        return response()->json(null, 204);
    }
}
