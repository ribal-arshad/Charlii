<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brainstorm extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'series_id',
        'book_id',
        'brainstorm_name',
        'audio_file',
        'description',
        'color_id',
        'transcript',
        'status',
        'image_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function image()
    {
        return $this->belongsTo(UserGallery::class, 'image_id');
    }

    public function rounds()
    {
        return $this->hasMany(BrainstormRound::class, 'brainstorm_id', 'id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
