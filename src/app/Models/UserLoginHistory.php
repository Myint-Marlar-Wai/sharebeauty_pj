<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    protected $fillable = [
        'login_attempt_at',
        'is_success',
        'email',
        'ip_address',
        'user_agent',
    ];
}
