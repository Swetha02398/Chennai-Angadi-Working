<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\OtpMail;
use Carbon\Carbon;

class RegisterController extends Controller
{

 public function customerRegister(Request $req)
    {
        // Validation
        $req->validate([
            'username' => ['required', 'string', 'unique:customers,username', 'regex:/^[a-zA-Z0-9._@+-]+$/'],
            'email' => 'required|email|unique:customers,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/'
            ],
            'confirm_password' => ['required', 'same:password'],
            'mobilenumber' => 'required|digits:10|unique:customers,mobilenumber',
        ], [
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters long',
            'password.regex' => 'Password must contain uppercase, lowercase, number, and special character',
            'confirm_password.same' => 'Confirm password does not match',
            'username.unique' => 'Username already taken',
            'email.unique' => 'Email already exists',
            'mobilenumber.unique' => 'Mobile number already registered',
            'mobilenumber.digits' => 'Mobile number must be 10 digits',
        ]);

        // Save customer
        $user = Customer::create([
            'username' => $req->username,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'mobilenumber' => $req->mobilenumber,
            'dob' => $req->dob,
            'address' => '',
            'pin' => '',
        ]);

        // Return JSON response
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully!',
            'data' => $user
        ], 201);
    }

public function customer()
{
    $customers = Customer::get();

    return response()->json([
        'status' => true,
        'count' => $customers->count(),
        'data' => $customers
    ], 200);
}

public function deleteCustomer($id)
{
    $deleted = Customer::destroy($id);

    if (!$deleted) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'message' => 'Customer deleted successfully'
    ], 200);
}

public function toggleStatus($id)
{
    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    $customer->status = $customer->status == 1 ? 0 : 1;
    $customer->save();

    return response()->json([
        'status' => true,
        'message' => 'Customer status updated successfully',
        'new_status' => $customer->status
    ], 200);
}

public function customerView($id)
{
    $customer = Customer::find($id);

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $customer
    ], 200);
}

public function login(Request $request)
{
    // Validate required fields to avoid null values (trim(null) causes TypeError on PHP 8+)
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string'
    ],[
        'login.required' => 'Login (email/username/mobile) is required',
        'password.required' => 'Password is required'
    ]);

    $login = trim((string) $request->input('login'));
    $password = trim((string) $request->input('password'));

    // Find customer by email, mobile or username
    $user = Customer::where('email', $login)
        ->orWhere('mobilenumber', $login)
        ->orWhere('username', $login)
        ->first();

    if (!$user) {
        return response()->json(['status' => false, 'message' => 'Customer not found'], 404);
    }

    // Password check
    if (!Hash::check($password, $user->password)) {
        return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
    }

    // Token generate
    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json([
        'status' => true,
        'token' => $token,
        'user'  => $user
    ], 200);
}

public function profileUpdate(Request $req)
{
    $req->validate([
        'username' => 'required',
        'email' => 'required|email',
        'mobilenumber' => 'required',
        'address' => 'required',
        'pin' => 'required',
        'gender' => 'nullable',
        'dob' => 'nullable|date',
        'city' => 'required',
        'state' => 'required',
        'country' => 'nullable',
        'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    // User ID pass panna body la
    $customer = \App\Models\Customer::find($req->user_id); 
    if (!$customer) {
        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    if ($req->hasFile('profile_image')) {
        $imageName = time().'.'.$req->profile_image->extension();
        $req->profile_image->move(public_path('uploads/profile'), $imageName);
        $customer->profile_image = $imageName;
    }

    $customer->update($req->except(['profile_image','user_id']));

    return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
}
// customer logout
public function logout(Request $request): JsonResponse
    {
        try {
            if ($request->user()) {
                $request->user()->currentAccessToken()->delete();
            }

            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ============================
    // 🔹 FORGOT PASSWORD FLOW
    // ============================

    /**
     * Step 1: Send OTP to customer's email
     * POST /api/customers/forgot-password
     * Body: { "email": "customer@email.com" }  (accepts email or mobile)
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string',
        ], [
            'email.required' => 'Email or mobile number is required',
        ]);

        $input = trim($request->email);

        // Find customer by email or mobile
        $customer = Customer::where('email', $input)
            ->orWhere('mobilenumber', $input)
            ->first();

        if (!$customer) {
            return response()->json([
                'status'  => false,
                'message' => 'No account found with this email or mobile number.',
            ], 404);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Store OTP in password_resets table
        DB::table('password_resets')->where('email', $customer->email)->delete();
        DB::table('password_resets')->insert([
            'email'      => $customer->email,
            'token'      => $otp,
            'created_at' => Carbon::now(),
        ]);

        // Send OTP via email
        try {
            Mail::to($customer->email)->send(new OtpMail($otp, $customer->username ?? 'Customer'));
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to send OTP email. Please try again later.',
                'error'   => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status'  => true,
            'message' => 'OTP sent to your registered email address.',
            'email'   => $this->maskEmail($customer->email),
        ], 200);
    }

    /**
     * Step 2: Verify OTP
     * POST /api/customers/verify-otp
     * Body: { "email": "customer@email.com", "otp": "123456" }
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string',
            'otp'   => 'required|digits:6',
        ]);

        $input = trim($request->email);

        // Find customer
        $customer = Customer::where('email', $input)
            ->orWhere('mobilenumber', $input)
            ->first();

        if (!$customer) {
            return response()->json([
                'status'  => false,
                'message' => 'Account not found.',
            ], 404);
        }

        // Check OTP
        $record = DB::table('password_resets')
            ->where('email', $customer->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid OTP. Please try again.',
            ], 400);
        }

        // Check if OTP expired (10 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            DB::table('password_resets')->where('email', $customer->email)->delete();
            return response()->json([
                'status'  => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 400);
        }

        return response()->json([
            'status'  => true,
            'message' => 'OTP verified successfully. You can now reset your password.',
        ], 200);
    }

    /**
     * Step 3: Reset Password
     * POST /api/customers/reset-password
     * Body: { "email": "...", "otp": "123456", "password": "NewPass@1", "confirm_password": "NewPass@1" }
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email'            => 'required|string',
            'otp'              => 'required|digits:6',
            'password'         => [
                'required', 'string', 'min:8',
                'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/',
            ],
            'confirm_password' => 'required|same:password',
        ], [
            'password.min'          => 'Password must be at least 8 characters long',
            'password.regex'        => 'Password must contain uppercase, lowercase, number, and special character',
            'confirm_password.same' => 'Confirm password does not match',
        ]);

        $input = trim($request->email);

        // Find customer
        $customer = Customer::where('email', $input)
            ->orWhere('mobilenumber', $input)
            ->first();

        if (!$customer) {
            return response()->json([
                'status'  => false,
                'message' => 'Account not found.',
            ], 404);
        }

        // Verify OTP again for security
        $record = DB::table('password_resets')
            ->where('email', $customer->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }

        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            DB::table('password_resets')->where('email', $customer->email)->delete();
            return response()->json([
                'status'  => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 400);
        }

        // Update password
        $customer->password = Hash::make($request->password);
        $customer->save();

        // Clean up OTP records
        DB::table('password_resets')->where('email', $customer->email)->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Password has been reset successfully. You can now login with your new password.',
        ], 200);
    }

    /**
     * Helper: Mask email for privacy (e.g., s****h@gmail.com)
     */
    private function maskEmail($email): string
    {
        $parts = explode('@', $email);
        $name = $parts[0];
        $domain = $parts[1];

        if (strlen($name) <= 2) {
            $masked = $name[0] . '***';
        } else {
            $masked = $name[0] . str_repeat('*', strlen($name) - 2) . substr($name, -1);
        }

        return $masked . '@' . $domain;
    }

}