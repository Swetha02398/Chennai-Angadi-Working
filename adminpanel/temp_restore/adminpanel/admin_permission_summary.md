# Admin User Permission System Summary

This document provides a comprehensive overview of the admin user permission system implemented in the Edumed360 project. You can use this as a blueprint for implementing similar logic in your new project.

## 1. Database Schema (Migrations)

The system uses five main tables to manage roles and permissions.

### Core Tables
- **`permissions`**: Stores individual permissions (e.g., `students-view`, `faculties-create`).
- **`roles`**: Stores user roles (e.g., `Manager`, `Editor`).
- **`users`**: Extended to include `role_id`, `role_type` (admin/superadmin), and `is_active`.

### Pivot Tables (Many-to-Many)
- **`role_permission`**: Maps permissions to roles.
- **`user_permission`**: Maps permissions directly to users (allows individual overrides).

```php
// permissions table
Schema::create('permissions', function (Blueprint $table) {
    $table->id();
    $table->string('name', 100);
    $table->string('slug', 100)->unique();
    $table->string('module', 50); // e.g., 'students', 'exams'
    $table->enum('action', ['view', 'create', 'edit', 'delete']);
    $table->text('description')->nullable();
    $table->timestamps();
});

// user_permission table (Direct overrides)
Schema::create('user_permission', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
    $table->timestamps();
});
```

---

## 2. Models & Relationships

### [Permission.php](file:///c:/xampp802/htdocs/laravel/edumed360/em-admin/app/Models/Permission.php)
Defines the structure of a permission and its relationship with roles.
- `roles()`: `belongsToMany(Role::class, 'role_permission')`

### [Role.php](file:///c:/xampp802/htdocs/laravel/edumed360/em-admin/app/Models/Role.php)
Defines a set of permissions.
- `permissions()`: `belongsToMany(Permission::class, 'role_permission')`
- `users()`: `hasMany(User::class)`
- `hasPermission($slug)`: Checks if the role has a permission.

### [User.php](file:///c:/xampp802/htdocs/laravel/edumed360/em-admin/app/Models/User.php)
The core logic for checking access.
- `role()`: `belongsTo(Role::class)`
- `permissions()`: `belongsToMany(Permission::class, 'user_permission')` (Direct permissions)
- **`hasPermission($slug)`**: The primary check. Logical flow:
    1. If `superadmin`, return `true` immediately.
    2. Check `user_permission` table for direct assignment.
    3. If not found, check `role_permission` via the user's role.

---

## 3. Authorization Logic (Middleware)

### [CheckPermission.php](file:///c:/xampp802/htdocs/laravel/edumed360/em-admin/app/Http/Middleware/CheckPermission.php)
A custom middleware used to protect routes.

```php
public function handle(Request $request, Closure $next, ...$permissions)
{
    $user = auth()->user();
    if ($user->isSuperAdmin()) return $next($request);

    foreach ($permissions as $permission) {
        if ($user->hasPermission($permission)) return $next($request);
    }
    abort(403);
}
```

---

## 4. UI Implementation (View)

The system features a matrix-style permission selector grouped by module.

### Features:
- **Grouping**: Permissions are grouped by `module` (e.g., Student Management, Faculty Management).
- **Bulk Actions**: JS-powered "Select All", "Clear", and Column-wise selection (e.g., "Select all View permissions").
- **Dynamic Feedback**: Visual indices to show which actions (View, Add, Edit, Delete) are available for each module.

---

## 5. Summary of Key Files for Porting

| File Type | Path in this project |
| :--- | :--- |
| **Model** | `app/Models/User.php`, `Role.php`, `Permission.php` |
| **Controller** | `app/Http/Controllers/Web/AdminPermissionWebController.php` |
| **Middleware** | `app/Http/Middleware/CheckPermission.php` |
| **Views** | `resources/views/access/admin/` |
| **Migrations** | `database/migrations/` (Search for `permissions` and `roles`) |

> [!TIP]
> When implementing in a new project, start with the Migrations, then the Models, and finally the Middleware. The Controller logic can be adapted once the foundation is ready.
