<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $appends = [
        'attachments',
    ];

    protected $fillable = [
        'parent_id',
        'group_id',
        'from_id',
        'to_id',
        'timeline_id',
        'outline_id',
        'plot_planner_id',
        'brainstorm_id',
        'book_id',
        'series_id',
        'message',
        'feature_type',
        'feature',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function to()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function brainstorm()
    {
        return $this->belongsTo(Brainstorm::class, 'brainstorm_id');
    }

    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    public function outline()
    {
        return $this->belongsTo(Outline::class, 'outline_id');
    }

    public function plot_planner()
    {
        return $this->belongsTo(PlotPlanner::class, 'plot_planner_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function series()
    {
        return $this->belongsTo(Series::class, 'series_id');
    }

    public function replies()
    {
        return $this->hasMany(Chat::class, 'parent_id')->with([
            'from:id,name,email',
            'brainstorm:id,brainstorm_name,audio_file',
            'timeline:id,name',
            'outline:id,outline_name',
            'plot_planner:id,plot_planner_title',
            'book:id,book_name',
            'series:id,series_name'
        ])->latest()->take(1);
    }

    public function hearts()
    {
        return $this->hasMany(ChatLike::class, "chat_id")->where("reaction", 1);
    }
    public function thumbs_up()
    {
        return $this->hasMany(ChatLike::class, "chat_id")->where("reaction", 2);
    }
    public function thumbs_down()
    {
        return $this->hasMany(ChatLike::class, "chat_id")->where("reaction", 3);
    }
    public function question_marks()
    {
        return $this->hasMany(ChatLike::class, "chat_id")->where("reaction", 4);
    }

    public function getAttachmentsAttribute()
    {
        return $this->getMedia('attachments');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
