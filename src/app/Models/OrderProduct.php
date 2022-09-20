<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_products';
    protected $fillable = [
        'order_id',
        'product_id',
        'sku',
        'product_name',
        'brand_id',
        'category_id',
        'shippingcosttype_id',
        'product_price',
        'seller_rate',
        'route_rate',
        'maker_rate',
        'quantity',
        'amount',
        'delete_flag',
        'create_date',
        'update_date',
    ];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
