<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(9);
        return view('admin-users', compact('users'));
    }

    // Show the form for editing a specific user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin-users-update', compact('user'));
    }

    // Update a specific user's data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin-users.index')->with('success', 'User updated successfully');
    }

    // Delete a specific user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin-users.index')->with('success', 'User deleted successfully');
    }
}
