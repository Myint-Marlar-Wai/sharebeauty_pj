<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDaily extends Model
{
    use HasFactory;

    protected $table = 'sales_daily';
    protected $fillable = [
        'shop_id',
        'parent_shop_id',
        'sales_date',
        'amount',
        'quantity',
        'amount_without_tax',
        'sellers_reward',
        'routes_reward',
        'aggs_date',
        'last_modified_id'
    ];
}
