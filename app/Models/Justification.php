<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
