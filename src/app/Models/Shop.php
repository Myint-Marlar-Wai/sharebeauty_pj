<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';
    protected $fillable = [
        'display_shop_id',
        'once_id',
        'parent_shop_id',
        'shop_name',
        'shop_text',
        'image1',
        'image2',
        'shop_type',
        'franchise_flag',
        'franchisee_flag',
        'template_id',
        'display_flag',
        'display_date',
        'delete_flag',
        'create_date',
        'update_date',
        'lastmodified_id',
    ];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
