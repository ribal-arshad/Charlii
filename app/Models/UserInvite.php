<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInvite extends Model
{
    protected $fillable = [
        'user_id',
        'invitee_id',
        'invitation_code',
    ];
}
