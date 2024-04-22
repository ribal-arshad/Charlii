<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'paypal_plan_id',
        'package_id',
        'package_type',
        'discount_amount',
    ];

}
