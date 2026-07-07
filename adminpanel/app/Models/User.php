<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role_id',
        'role_type',
        'profile_image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Role relationship
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Direct permissions (user-level overrides)
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    /**
     * Check if user is a super admin
     */
    public function isSuperAdmin()
    {
        return $this->role_type === 'superadmin';
    }

    /**
     * Check if the user has a specific permission.
     * Logic:
     *  1. If superadmin → always true
     *  2. Check direct user_permission table
     *  3. Check role_permission via user's role
     */
    public function hasPermission($slug)
    {
        // Super admin bypasses all permission checks
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Check direct user-level permissions
        if ($this->permissions()->where('slug', $slug)->exists()) {
            return true;
        }

        // Check role-level permissions
        if ($this->role && $this->role->hasPermission($slug)) {
            return true;
        }

        return false;
    }

    /**
     * Get all permission slugs for this user (merged: role + direct)
     */
    public function getAllPermissions()
    {
        $directPermissions = $this->permissions()->pluck('slug')->toArray();

        $rolePermissions = [];
        if ($this->role) {
            $rolePermissions = $this->role->permissions()->pluck('slug')->toArray();
        }

        return array_unique(array_merge($directPermissions, $rolePermissions));
    }
}
