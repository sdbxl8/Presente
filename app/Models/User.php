<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Group;
use App\Models\Attendance;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'surname', 'email', 'password','role','group_id','subject_name','photo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public function studentGroups()
    {
        return $this->belongsToMany(
            Group::class,
            'group_student',
            'student_id',
            'group_id'
        )->withTimestamps();
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'teacher_id');
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
