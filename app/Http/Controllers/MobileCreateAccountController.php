<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MobileCreateAccountController extends Controller
{
    public function createAccount(Request $request)
    {
        return User::create([
            'id' => $request->id,
            'first_name' => $request->first_name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
            'membership_plan' => $request->membership_plan,
        ]);

    }
}
