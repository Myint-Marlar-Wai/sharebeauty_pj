<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Definitions\DMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $table = 'members';

    protected $fillable = [
        'display_member_id',
        'email',
        'last_modified_admin_id',
    ];

    public static function def(?string $as) : DMember
    {
        return (new DMember(static::class))->initialize(as: $as);
    }
}
