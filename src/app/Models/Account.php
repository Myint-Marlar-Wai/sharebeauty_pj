<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{    
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'once_id',
        'bank_code',
        'bank_name',
        'branch_code',
        'branch_name',
        'account_type',
        'account_number',
        'account_name',
        'account_kana',
        'account_memo',
        'alert_flag',
        'alert_message',
        'delete_flag',
        'create_date',
        'update_date',
        'lastmodified_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];
}
