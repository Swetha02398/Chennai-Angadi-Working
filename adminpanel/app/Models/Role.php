<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    /**
     * Permissions belonging to this role
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Users that belong to this role
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if this role has a specific permission
     */
    public function hasPermission($slug)
    {
        return $this->permissions()->where('slug', $slug)->exists();
    }
}
