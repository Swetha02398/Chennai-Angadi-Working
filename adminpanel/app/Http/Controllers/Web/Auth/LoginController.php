<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $input = $request->input('username');
        $password = $request->input('password');

        // Check if input is email, username, or phone
        $fieldType = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 
                     (is_numeric($input) ? 'phone' : 'username');

        $credentials = [$fieldType => $input, 'password' => $password];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ Redirect to dashboard route after successful login
            return redirect()->route('index')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'username' => 'Invalid username, email, phone, or password.',
        ])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
