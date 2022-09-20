<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Definitions\DSeller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Seller extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'sellers';

//    protected $appends = ['password'];

    protected $fillable = [
        'email',
        'google_id',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    public function userPassword()
    {
        return $this->hasOne(SellerPassword::class, 'seller_id');
    }

    public function profile()
    {
        return $this->hasOne(SellerProfile::class, 'seller_id');
    }

    public static function def(?string $as) : DSeller
    {
        return (new DSeller(static::class))->initialize(as: $as);
    }

}
