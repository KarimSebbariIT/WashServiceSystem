<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; // ✅ must be imported
use Illuminate\Notifications\Notifiable;
/**
 * @mixin \Laravel\Sanctum\HasApiTokens
 */
class UserAccount extends Authenticatable
{
    use HasApiTokens, Notifiable; // ✅ must use the trait

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
