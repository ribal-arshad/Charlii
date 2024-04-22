<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'series_id',
        'color_id',
        'book_name',
        'book_description',
        'is_finished',
        'status',
        'image_id',
        'created_at',
        'updated_at',
    ];

    public function bookBrainstorms()
    {
        return $this->hasMany(Brainstorm::class, 'book_id', 'id');
    }

    public function bookTimelines()
    {
        return $this->hasMany(Timeline::class, 'book_id', 'id');
    }

    public function bookOutlines()
    {
        return $this->hasMany(Outline::class, 'book_id', 'id');
    }

    public function bookPremises()
    {
        return $this->hasMany(Premise::class, 'book_id', 'id');
    }

    public function bookSeries()
    {
        return $this->belongsToMany(Series::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'book_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function image()
    {
        return $this->belongsTo(UserGallery::class, 'image_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
