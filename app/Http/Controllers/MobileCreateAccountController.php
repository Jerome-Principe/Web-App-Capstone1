<?php

namespace App\Http\Controllers;

use App\Models\PendingMembership;
use Illuminate\Http\Request;

class MobileCreateAccountController extends Controller
{
    public function createAccount(Request $request)
    {
        return PendingMembership::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Encrypt the password
            'status' => 'Pending', // Set initial status as pending
        ]);

    }
}
