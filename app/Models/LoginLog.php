<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = ['user_id', 'action', 'action_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
