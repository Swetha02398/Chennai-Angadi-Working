<?php

namespace App\Http\Controllers\Web\Auth;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the register form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration logic
     */
    public function register(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
            'role_type' => 'required|in:admin,superadmin',
            'role_id' => 'nullable|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle profile image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('uploads/profile'), $imageName);
            $imagePath = 'uploads/profile/' . $imageName;
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_type' => $request->role_type,
            'role_id' => $request->role_id,
            'profile_image' => $imagePath,
            'status' => 1,
        ]);


   // Redirect to dashboard or login
     return redirect()->route('login')->with('success', 'Registration successful!');
}



// Customer Register



    public function customerRegister()
    {
   
        return view('auth.customerRegister');

    }

    public function store(Request $req)
    {

      // 1️⃣ Validation
    $req->validate([
    'username' => ['required', 'string', 'unique:customers,username', 'regex:/^[a-zA-Z0-9._@+-]+$/'],
    'email' => 'required|email|unique:customers,email',
    'password' => [
        'required',
        'string',
        'min:8',
        'regex:/[a-z]/',       // lowercase
        'regex:/[A-Z]/',       // uppercase
        'regex:/[0-9]/',       // number
        'regex:/[@$!%*?&#]/'   // special character
    ],
    'confirm_password' => ['required', 'same:password'],
    'mobilenumber' => 'required|digits:10|unique:customers,mobilenumber',
    'address' => 'required|string|max:255',
    'pin' => 'required|digits:6',
], [
    // Custom messages
    'password.required' => 'Password is required',
    'password.min' => 'Password must be at least 8 characters long',
    'password.regex' => 'Password must contain a strong password (uppercase, lowercase, number, special character)',
    'confirm_password.required' => 'Confirm password is required',
    'confirm_password.same' => 'Confirm password does not match the password.',
    'username.required' => 'Username is required',
    'username.unique' => 'Username already taken',
    'email.required' => 'Email is required',
    'email.email' => 'Enter a valid email',
    'email.unique' => 'Email already exists',
    'mobilenumber.required' => 'Mobile number is required',
    'mobilenumber.digits' => 'Mobile number must be 10 digits',
    'mobilenumber.unique' => 'Mobile number already registered',
    'address.required' => 'Address is required',
    'pin.required' => 'PIN code is required',
    'pin.digits' => 'PIN code must be 6 digits',
]);

        

        // 3️⃣ Save to DB
        $user = new Customer();
        $user->username = $req->username;
         $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->mobilenumber = $req->mobilenumber;
        $user->address = $req->address;
        $user->pin = $req->pin;
        $user->dob = $req->dob;
        $user->save();

    

        // 4️⃣ Response
        return redirect()->route('customer')->with('success', 'User registered successfully!');
    }

    



    public function checkUniqueness(Request $request)
    {
        $field = $request->get('field');
        $value = $request->get('value');
        
        $exists = Customer::where($field, $value)->exists();
        
        return response()->json([
            'exists' => $exists
        ]);
    }

   public function customer(Request $request)
   {
    $query = Customer::query();

    // Search functionality
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('username', 'LIKE', '%' . $search . '%')
              ->orWhere('email', 'LIKE', '%' . $search . '%')
              ->orWhere('mobilenumber', 'LIKE', '%' . $search . '%')
              ->orWhere('address', 'LIKE', '%' . $search . '%');
    }

    // Filter by status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    // Pagination with 10 items per page
    $customers = $query->paginate(10);

    return view('product.customer', [
        'customers' => $customers,
        'search' => $request->search ?? '',
        'status' => $request->status ?? ''
    ]);
   }
   public function deleteCustomer($id)
   {
    // Find and delete the customer directly
    Customer::destroy($id); // This deletes the customer by ID
    return redirect()->route('customer')->with('success', 'Customer deleted successfully!');
   }
   
    public function toggleStatus($id)
    {

       $customer = Customer::findOrFail($id);

    // Flip status
       $customer->status = $customer->status == 1 ? 0 : 1;
       $customer->save();

       return redirect()->route('customer') ->with('success', 'Customer status updated successfully!');
  
    }
    public function customerView($id)
    {

       $customer = Customer::findOrFail($id);
       return view('product.customerView', compact('customer'));
   
    }

    public function customerEdit($id)
    {
       $customer = Customer::findOrFail($id);
       return view('product.customerEdit', compact('customer'));
    }

    public function customerUpdate(Request $request, $id)
    {
       $customer = Customer::findOrFail($id);

       $request->validate([
           'username' => 'required|string',
           'email' => 'required|email|unique:customers,email,' . $id,
           'mobilenumber' => 'required|digits:10|unique:customers,mobilenumber,' . $id,
           'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
           'pin' => 'nullable|digits:6',
       ]);

       if ($request->hasFile('profile_image')) {
           $imageName = time() . '.' . $request->profile_image->extension();
           $request->profile_image->move(public_path('uploads/profile'), $imageName);
           $customer->profile_image = $imageName;
       }

       $customer->username = $request->username;
       $customer->email = $request->email;
       $customer->mobilenumber = $request->mobilenumber;
       $customer->gender = $request->gender;
       $customer->dob = $request->dob;
       $customer->address = $request->address;
       $customer->city = $request->city;
       $customer->state = $request->state;
       $customer->country = $request->country;
       $customer->pin = $request->pin;
       
       $customer->save();

       return redirect()->back()->with('success', 'Customer profile updated successfully!');
    }
   public function export()
    {
        $customers = Customer::all();
        
        $fileName = 'customers_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        
        $output = fopen('php://output', 'w');
        
        // Add BOM for Excel UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Add headers
        fputcsv($output, ['ID', 'Username', 'Email', 'Mobile Number', 'Address', 'PIN', 'Gender', 'Date of Birth', 'City', 'State', 'Country', 'Status', 'Created At']);
        
        // Add customer data
        foreach ($customers as $customer) {
            fputcsv($output, [
                $customer->id,
                $customer->username,
                $customer->email,
                $customer->mobilenumber,
                $customer->address,
                $customer->pin,
                $customer->gender ?? 'N/A',
                $customer->dob,
                $customer->city ?? 'N/A',
                $customer->state ?? 'N/A',
                $customer->country ?? 'N/A',
                $customer->status == 1 ? 'Active' : 'Inactive',
                $customer->created_at,
               
            ]);
        }
        
        fclose($output);
        exit();
    }

}
    

