<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Series extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'series_name',
        'series_description',
        'is_finished',
        'color_id',
        'status',
        'image_id',
        'created_at',
        'updated_at',
    ];
}
