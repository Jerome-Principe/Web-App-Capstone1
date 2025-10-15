<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('role', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('id', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Order user by creation date, showing newest first
        $users = $query->orderBy('id', 'desc')->paginate(9);

        // Preserve search parameter in pagination links
        if ($request->has('search')) {
            $users->appends(['search' => $request->search]);
        }

        // If it's an AJAX request, return only the table content
        if ($request->ajax()) {
            return view('admin-users', compact('users'))->render();
        }

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
            'role' => 'required|in:Admin,Cashier,Instructor',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

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
