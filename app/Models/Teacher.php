<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Teacher extends Authenticatable
{
    protected $guard='Teacher';
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'name',
        'country',
        'subject',
        'image',
        'video',
        'description',
        'phone',
        'CostHour',
        'password',
        'verification_code',
        'status',

    ];

    public function working_hour(){
        return $this->hasMany(WorkingHours::class);
    }

    public function followers(){
        return $this->belongsToMany(User::class,'teacher_followers','teacher_id');

    }

}
