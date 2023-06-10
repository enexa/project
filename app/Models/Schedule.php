<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'course_id',
        'schedule_datetime',
        'description',
    ];

    // Define the relationship with the teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Define the relationship with the course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
