<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'deleted_by',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "deleted_by");
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
