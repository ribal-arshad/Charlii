<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table='coupons';
    protected $fillable=[
        'coupon_code',
        'package_id',
        'discount_amount',
        'number_of_usage',
        'package_type',
        'discount_type',
        'date_of_expiry',
        'status',
        'usage_count'
    ];


}
