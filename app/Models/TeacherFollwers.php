<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherFollwers extends Model
{
    use HasFactory;
protected $table='teacher_followers';
    protected $fillable=[
        'user_id',
        'teacher_id'
    ];

    protected $hidden=[
        'updated_at',
        'created_at'
    ];
}
