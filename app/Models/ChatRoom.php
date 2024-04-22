<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
    ];

    public function contactUser()
    {
        return $this->belongsTo(User::class, "contact_id");
    }
}
