<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const SUPER_ADMIN = 'super_admin'; // Full system control
    const MANAGER     = 'manager';     // Manage members, view reports
    const STAFF       = 'staff';       // Create and view members
    const MEMBER      = 'member';      // View own profile only

    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
