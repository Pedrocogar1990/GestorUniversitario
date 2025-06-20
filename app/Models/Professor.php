<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'lastname',
        'dni',
        'tutor',
        'email',
        'department',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
