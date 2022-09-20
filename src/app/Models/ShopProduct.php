<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $table = 'shop_products';
    protected $fillable = [
        'shop_id',
        'product_id',
        'display_flag',
        'sort_num',
        'ext_image1',
        'ext_image2',
        'ext_image3',
        'ext_image4',
        'ext_image5',
        'ext_image6',
        'ext_text',
        'delete_flag',
        'create_date',
        'update_date',
        'lastmodified_id',
    ];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
