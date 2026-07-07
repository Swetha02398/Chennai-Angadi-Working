<?php
namespace App\Http\Controllers\Web\Auth;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    // Show the edit profile form
    public function editProfile()
    {
        $user = Auth::user(); // get the logged-in user
        return view('auth.edit-profile', compact('user'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
       if ($request->hasFile('profile_image')) {

    // delete old image
    if ($user->profile_image && File::exists(public_path('assets/uploads/admin_profiles/' . $user->profile_image))) {
        File::delete(public_path('assets/uploads/admin_profiles/' . $user->profile_image));
    }

    // save new image (SHORT filename)
    $file = $request->file('profile_image');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('assets/uploads/admin_profiles'), $filename);

    $user->profile_image = $filename;
}
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

}