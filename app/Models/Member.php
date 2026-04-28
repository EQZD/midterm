<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'membership_type',
        'join_date',
        'status',
        'expiry_date',
    ];

    /**
     * Файлы прикреплённые к этому члену клуба
     */
    public function files()
    {
        return $this->hasMany(MemberFile::class);
    }
}