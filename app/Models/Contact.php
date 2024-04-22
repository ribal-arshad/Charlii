<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public const STATUS_RADIO = [
        '0' => 'User',
        '1' => 'Group',
    ];

    protected $fillable = [
        'user_id',
        'contact_id',
        'group_id',
        'contact_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactUser()
    {
        return $this->belongsTo(User::class, "contact_id");
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function getTypeOfContactAttribute() {
        return self::STATUS_RADIO[$this->contact_type];
    }

    public function contact_latest_chat()
    {
        return $this->hasOne(Chat::class, "from_id", "user_id")->latest();
    }
}
