<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'thumbnail', 'video', 'teacher_id','students'];
    protected $casts = [
        'students' => 'array',
    ];
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function enrolledStudents()
{
    return User::whereIn('id', $this->students)->get(['name', 'image']);
}

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    

}
