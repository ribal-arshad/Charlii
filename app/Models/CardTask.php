<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class CardTask extends Model
{
    public const TASK_TYPE_SELECT = [
        '1' => 'Todo list',
        '2' => 'Brainstorm',
        '3' => 'Outline',
        '4' => 'Timeline',
        '5' => 'Plot Planner',
    ];

    protected $fillable = [
        'user_id',
        'series_id',
        'book_id',
        'outline_id',
        'chapter_id',
        'card_id',
        'task_type',
        'todo_item',
        'todo_date',
        'todo_time',
        'brainstorm_item_id',
        'outline_item_id',
        'timeline_item_id',
        'plot_planner_item_id',
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

    public function card()
    {
        return $this->belongsTo(ChapterCard::class, 'card_id');
    }

    public function brainstorm_item()
    {
        return $this->belongsTo(Brainstorm::class, 'brainstorm_item_id');
    }

    public function outline_item()
    {
        return $this->belongsTo(Outline::class, 'outline_item_id');
    }

    public function timeline_item()
    {
        return $this->belongsTo(Timeline::class, 'timeline_item_id');
    }

    public function plotplanner_item()
    {
        return $this->belongsTo(PlotPlanner::class, 'plot_planner_item_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getTodoDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i:s') : null;
    }

    public function getTodoTimeAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('H:i:s') : null;
    }
}
