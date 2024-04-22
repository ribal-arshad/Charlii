<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponImportLog extends Model
{
    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'coupon_code',
        'detail',
        'status',
    ];
}
