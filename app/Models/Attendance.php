<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public function classSession()
    {
        return $this->belongsTo(ClassSession::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function justification()
    {
        return $this->hasOne(Justification::class);
    }
}
