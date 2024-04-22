<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'user_id',
        'series_id',
        'book_id',
        'outline_id',
        'chapter_name',
        'status',
        'color_id',
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

    public function outline()
    {
        return $this->belongsTo(Outline::class, 'outline_id');
    }

    public function cards()
    {
        return $this->hasMany(ChaptersCard::class);
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
