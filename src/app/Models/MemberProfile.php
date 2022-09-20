<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Definitions\DMember;
use App\Models\Definitions\DMemberProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberProfile extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $table = 'member_profiles';

    protected $fillable = [
        'lastname',
        'firstname',
        'lastname_kana',
        'firstname_kana',
        'zip',
        'pref_code',
        'address',
        'address_other',
        'tel',
        'gender',
        'birthday',
        'delete_flag',
        'create_date',
        'update_date',
        'last_modified_admin_id',
    ];

    public static function def(?string $as) : DMemberProfile
    {
        return (new DMemberProfile(static::class))->initialize(as: $as);
    }
}
