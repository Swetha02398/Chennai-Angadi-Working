<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Str;

class AdminPermissionWebController extends Controller
{
    /**
     * List all roles
     */
    public function index(Request $request)
    {
        $query = Role::withCount(['permissions', 'users']);

        $search = $request->search;
        $status = $request->status;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        $roles = $query->paginate(15);
        return view('access.admin.role-index', compact('roles', 'search', 'status'));
    }

    /**
     * Show create role form
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy('module');
        return view('access.admin.role-create', compact('permissions'));
    }

    /**
     * Store a new role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Show edit role form
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all()->groupBy('module');
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        return view('access.admin.role-edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    /**
     * Update a role
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Delete a role
     */
    public function destroy($id)
    {
        $role = Role::withCount('users')->findOrFail($id);

        if ($role->users_count > 0) {
            return redirect()->back()->with('error', 'Cannot delete role. ' . $role->users_count . ' user(s) are assigned to this role.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully!');
    }

    /**
     * List all admin users
     */
    public function adminUsers(Request $request)
    {
        $query = User::with('role');

        $search = $request->search;
        $status = $request->status;

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('username', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        $users = $query->orderBy('role_type', 'desc')->orderBy('name')->paginate(15);
        return view('access.admin.users', compact('users', 'search', 'status'));
    }

    /**
     * Show create admin user form
     */
    public function createAdmin()
    {
        $roles = Role::all();
        return view('access.admin.create-user', compact('roles'));
    }

    /**
     * Store a new admin user
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users,username',
            'email'         => 'required|email|max:255|unique:users,email',
            'phone'         => 'required|string|max:20|unique:users,phone',
            'password'      => 'required|string|min:6|confirmed',
            'role_type'     => 'required|in:admin,superadmin',
            'role_id'       => 'nullable|exists:roles,id',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => bcrypt($request->password),
            'role_type' => $request->role_type,
            'role_id'   => $request->role_id,
            'status'    => 1,
        ];

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/admin_profiles'), $filename);
            $data['profile_image'] = $filename;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully!');
    }

    /**
     * Show edit admin user form
     */
    public function editAdmin($id)
    {
        $user = User::with(['role', 'permissions'])->findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all()->groupBy('module');
        $userPermissionIds = $user->permissions->pluck('id')->toArray();

        return view('access.admin.edit-user', compact('user', 'roles', 'permissions', 'userPermissionIds'));
    }

    /**
     * Update admin user role & permissions
     */
    public function updateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'         => 'required|string|max:20|unique:users,phone,' . $user->id,
            'role_id'       => 'nullable|exists:roles,id',
            'role_type'     => 'required|in:admin,superadmin',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        $user->role_type = $request->role_type;

        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($user->profile_image && \Illuminate\Support\Facades\File::exists(public_path('assets/uploads/admin_profiles/' . $user->profile_image))) {
                \Illuminate\Support\Facades\File::delete(public_path('assets/uploads/admin_profiles/' . $user->profile_image));
            }

            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/admin_profiles'), $filename);
            $user->profile_image = $filename;
        }

        $user->save();

        $user->permissions()->sync($request->permissions ?? []);

        return redirect()->route('admin.users.index')->with('success', 'Admin user updated successfully!');
    }

    /**
     * Delete an admin user
     */
    public function deleteAdmin($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Prevent deleting super admin
        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Super Admin accounts cannot be deleted.');
        }

        $user->permissions()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Admin user deleted successfully!');
    }

    /**
     * Toggle role status (Active/Inactive)
     */
    public function toggleRole($id)
    {
        $role = Role::findOrFail($id);
        $role->status = !$role->status;
        $role->save();

        return redirect()->back()->with('success', 'Role status updated successfully!');
    }

    /**
     * Toggle admin user status (Active/Inactive)
     */
    public function toggleUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Cannot change Super Admin status.');
        }

        $user->status = !$user->status;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully!');
    }
}
