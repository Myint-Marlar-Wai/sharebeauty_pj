<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'product_catch',
        'product_name',
        'sku',
        'brand_id',
        'category_id',
        'shippingcosttype_id',
        'maker_id',
        'maker_rate',
        'product_price',
        'seller_rate',
        'route_rate',
        'image1',
        'image2',
        'image3',
        'image4',
        'image5',
        'text1',
        'text2',
        'text3',
        'text4',
        'text5',
        'text6',
        'text7',
        'text8',
        'text9',
        'text10',
        'sort_num',
        'delete_flag',
        'create_date',
        'update_date',
        'lastmodified_id',
    ];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
