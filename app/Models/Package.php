<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'package_name',
        'description',
        'color_id',
        'price_monthly',
        'yearly_discount',
        'price_yearly',
        'paypal_product_id',
        'paypal_monthly_plan_id',
        'paypal_yearly_plan_id',
        'status',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
