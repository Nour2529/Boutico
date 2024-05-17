<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|string|min:6',
        'role' => 'boolean|in:0,1',
    ]);

    $hashedPassword = bcrypt($request->input('password'));

    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $hashedPassword,
        'role' => $request->input('role'),
    ]);

    return response()->json($user, 201);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users|max:255',
            'password' => 'string|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
