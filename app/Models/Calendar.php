<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendar extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'color_id',
    ];

    public function getEventDateFormattedAttribute($value)
    {
        return (new Carbon($value))->format('F d, Y');
    }

    public function setEventDateAttribute($value)
    {
        $this->attributes['event_date'] = date('Y-m-d', strtotime($value));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
