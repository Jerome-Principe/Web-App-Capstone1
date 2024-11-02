<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MobileCreateAccountController extends Controller
{
    public function createAccount(Request $request)
    {
        return User::create([
            'name' => $request->first_name . ' ' . $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
        ]);

    }
}
