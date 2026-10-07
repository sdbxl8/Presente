<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justification extends Model
{
    protected $fillable = [
        'attendance_id',
        'reason',
        'document_path',
        'status',
    ];

    public function attendance()
    {

        return $this->belongsTo(Attendance::class);
    }


}


