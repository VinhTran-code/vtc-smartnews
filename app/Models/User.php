<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = ['name', 'username', 'password', 'phone', 'address'];

    protected $hidden = ['password', 'remember_token'];

    // Một người dùng có nhiều phiên chat AI
    public function chatSessions(): HasMany
    {
        return $this->hasMany(ChatSession::class);
    }
}