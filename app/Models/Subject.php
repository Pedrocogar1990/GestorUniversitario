<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'subjectCode',
        'credits',
        'career_id',
        'professor_id',
    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
                    ->withTimestamps()
                    ->withPivot('fecha_matricula');
    }
}
