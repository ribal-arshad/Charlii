<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChapterCard extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'series_id',
        'book_id',
        'outline_id',
        'chapter_id',
        'card_title',
        'card_description',
        'color_id',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    public function tasks()
    {
        return $this->hasMany(CardTask::class, 'card_id');
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
