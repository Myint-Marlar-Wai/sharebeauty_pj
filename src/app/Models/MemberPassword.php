<?php

namespace App\Models;

use App\Models\Definitions\DMember;
use App\Models\Definitions\DMemberPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPassword extends Model
{
    protected $table = 'member_passwords';
    protected $fillable = [
        'member_id',
        'password',
    ];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public static function def(?string $as) : DMemberPassword
    {
        return (new DMemberPassword(static::class))->initialize(as: $as);
    }
}
