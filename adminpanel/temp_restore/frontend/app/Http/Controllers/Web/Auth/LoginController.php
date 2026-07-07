<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;

class LoginController extends Controller
{
    // Show login form
    public function login()
    {
        return view('auth.login');
    }

    public function insert(Request $req)
    {
        $req->validate([
            'login_id' => 'required',
            'password' => 'required'
        ]);

        $login_id = $req->login_id;

        // Determine type: email / mobile / username
        $fieldType = filter_var($login_id, FILTER_VALIDATE_EMAIL) ? 'email'
            : (is_numeric($login_id) ? 'mobilenumber' : 'username');

        // Step 1: Check if login_id exists
        $customer = Customer::where($fieldType, $login_id)->first();

        if (!$customer) {
            return back()->withErrors([
                'login_id' => 'Invalid login details!',
            ])->withInput();
        }

        // Step 2: Check password
        if (!Hash::check($req->password, $customer->password)) {
            return back()->withErrors([
                'password' => 'Password is incorrect!',
            ])->withInput();
        }

        // Step 3: Check if customer is active (admin sets status 0=inactive, 1=active)
        if (empty($customer->status) || $customer->status == 0 || $customer->status === '0') {
            return back()->withErrors([
                'login_id' => 'Your account has been deactivated. Please contact support.',
            ])->withInput();
        }

        // Step 4: Login
        Auth::guard('customer')->login($customer);

        // Handle redirect after login (for wishlist/cart etc)
        $redirectUrl = $req->input('redirect') ?? session('url.intended') ?? route('index');
        return redirect($redirectUrl)->with('success', 'Login successfully!');
    }

    public function showForgetForm()
    {
        return view('auth.forgetpassword');
    }

    // SEND OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'login_id' => 'required'
        ]);

        $login = $request->login_id;

        // find customer with email or mobile
        $customer = Customer::where('email', $login)
            ->orWhere('mobilenumber', $login)
            ->first();

        if (!$customer) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }
            return back()->with('error', 'User not found');
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in password_resets table
        DB::table('password_resets')->updateOrInsert(
            ['email' => $customer->email],
            ['token' => $otp, 'created_at' => Carbon::now()]
        );

        // Send OTP via email
        try {
            Mail::to($customer->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("OTP Email Error: " . $e->getMessage());
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP email. Please try again.'], 500);
            }
            return back()->with('error', 'Failed to send OTP email. Please try again.');
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'OTP sent successfully', 'login_id' => $login]);
        }

        return back()->with('otp_send', true)
            ->with('login_id', $login)
            ->with('message', 'OTP sent successfully');
    }

    // VERIFY OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'otp' => 'required'
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->login_id)
            ->first();

        if (!$record || $record->token != $request->otp) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Incorrect OTP'], 400);
            }
            return back()->with('otp_send', true)
                ->with('login_id', $request->login_id)
                ->with('error', 'Incorrect OTP');
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'OTP Verified Successfully']);
        }

        return back()->with('otp_verified', true)
            ->with('login_id', $request->login_id)
            ->with('message', 'OTP Verified Successfully');
    }

    // RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $customer = Customer::where('email', $request->login_id)
            ->orWhere('mobilenumber', $request->login_id)
            ->first();

        $customer->password = Hash::make($request->password);
        $customer->save();

        // delete otp record
        DB::table('password_resets')->where('email', $request->login_id)->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Password changed successfully']);
        }

        return redirect()->route('login')->with('message', 'Password changed successfully');
    }
}