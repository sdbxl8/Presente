<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function classSessions()
    {
        return $this->hasMany(ClassSession::class);
    }
    protected $fillable = [
        'name',
        'group_id',
    ];
}
