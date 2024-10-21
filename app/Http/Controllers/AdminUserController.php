<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Log;

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
        return view('admin-users-edit', compact('user'));
    }

    // Update a specific user's data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
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
