<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function store(Request $req)
    {
        $req->validate([
            'username' => 'required|string|max:255|unique:customers,username',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|confirmed|min:8',
            'mobilenumber' => 'required|digits:10|unique:customers,mobilenumber',
            'agree' => 'accepted'

        ], [
            // Custom messages
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'mobilenumber.unique' => 'This mobile number is already registered.',
            'agree.accepted' => 'You must agree to the terms & policy.',
        ]);


        // 3️⃣ Save to DB
        $user = new Customer();
        $user->username = $req->username;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->mobilenumber = $req->mobilenumber;
        $user->address = '';
        $user->pin = '';
        // Convert checkbox to 0/1
        $user->agree = $req->has('agree') ? 1 : 0;
        $user->save();

        // Auto-login the new user
        Auth::guard('customer')->login($user);

        // 4️⃣ Response
        if ($req->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Account created successfully!']);
        }
        return redirect()->route('index')->with('success', 'User registered successfully!');
    }



}