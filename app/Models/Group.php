<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Alumnos inscritos en este grupo.
     */
    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'group_student',
            'group_id',
            'student_id'
        )
            ->where('users.role', 'student')
            ->withTimestamps();
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    protected $fillable = [
        'name',
        'teacher_id',
    ];
}
