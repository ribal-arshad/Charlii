<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class Group extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $appends = [
        'group_icon',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'group_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit(Fit::Crop, 50, 50)->nonQueued();
        $this->addMediaConversion('preview')->fit(Fit::Crop, 120, 120)->nonQueued();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getGroupIconAttribute()
    {
        $file = $this->getMedia('group_icon')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function latest_chat() {
        return $this->hasOne(Chat::class)->latest();
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
