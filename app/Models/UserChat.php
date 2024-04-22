<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        "chat_id",
        "to_id",
        "group_id",
        "is_read",
        "is_delete"
    ];

    public function chat() {
        return $this->belongsTo(Chat::class);
    }

    public function toUser() {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
