<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;

class ForgotPasswordController extends Controller
{
    // Step 1: Show Email Form
    public function showEmailForm()
    {
        return view('auth.passwords.email');
    }

    // Step 2: Send OTP
    public function sendOtp(Request $request)
    {
        \Log::info('Admin forgot password request initiated', ['email' => $request->email]);
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $email = $request->email;

        // Store OTP in password_resets table
        // Delete old tokens for this email
        DB::table('password_resets')->where('email', $email)->delete();

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $otp, // Reuse token column for OTP
            'created_at' => Carbon::now()
        ]);

        // Send Email
        try {
            Mail::to($email)->send(new OtpMail($otp));
            \Log::info('Admin forgot password OTP notification sent successfully', [
                'email' => $email,
                'otp' => $otp,
            ]);
        } catch (\Exception $e) {
            \Log::error('Admin forgot password OTP email failed', [
                'email' => $email,
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors(['email' => 'Failed to send OTP email. Please try again later.']);
        }

        return redirect()->route('password.otp.form', ['email' => $email])
            ->with('success', 'OTP sent to your email address.');
    }

    // Step 3: Show OTP Form
    public function showOtpForm(Request $request)
    {
        $email = $request->query('email');
        return view('auth.passwords.otp', compact('email'));
    }

    // Step 4: Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // Check expiration (e.g., 15 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors(['otp' => 'OTP expired. Please request a new one.']);
        }

        // If valid, show reset password form with email and token (OTP) as hidden fields
        // Or store verified state in session. For simplicity and security, we can pass signed URL or just forward.
        // Let's pass the email and OTP to the reset form via query params, but verify again on submit.
        
        return redirect()->route('password.reset.form', ['email' => $request->email, 'token' => $request->otp])
            ->with('success', 'OTP verified. Please reset your password.');
    }

    // Step 5: Show Reset Password Form
    public function showResetForm(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');

        // Basic validation again just in case
        if (!$email || !$token) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid request.']);
        }

        return view('auth.passwords.reset', compact('email', 'token'));
    }

    // Step 6: Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required', // OTP
            'password' => 'required|min:8|confirmed',
        ]);

        // Verify OTP again
        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['token' => 'Invalid or expired session.']);
        }

        // Update User Password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete OTP
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login.');
    }
}
