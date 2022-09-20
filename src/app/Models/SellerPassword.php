<?php

namespace App\Models;

use App\Models\Definitions\DSellerPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPassword extends Model
{
    protected $table = 'seller_passwords';
    protected $fillable = [
        'seller_id',
        'password',
    ];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public static function def(?string $as) : DSellerPassword
    {
        return (new DSellerPassword(static::class))->initialize(as: $as);
    }
}
