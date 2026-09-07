<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password_hash',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    /**
     * Name of password column for authentication
     */
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    /**
     * Password value for authentication
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * Check if user is admin / perawat
     */
    public function isAdmin(): bool
    {
        return true;
    }

    /**
     * Human-readable role label
     */
    public function getRoleLabelAttribute(): string
    {
        return 'Admin / Perawat';
    }
}
