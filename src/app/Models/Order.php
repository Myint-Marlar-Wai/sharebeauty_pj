<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'display_order_id',
        'shop_id',
        'parent_shop_id',
        'member_id',
        'subtotal',
        'salestax',
        'shippingcost',
        'amount',
        'quantity',
        'deliverycompany_id',
        'trackingnumber',
        'payment_gmo_id',
        'payment_method',
        'payment_status',
        'payment_date_temporary',
        'payment_date',
        'order_status',
        'order_status_date',
        'order_date',
        'preparation_date',
        'shipping_date',
        'order_ip',
        'order_useragent',
        'delete_flag',
        'create_date',
        'update_date',
        'lastmodified_id',
    ];
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'update_date';
}
