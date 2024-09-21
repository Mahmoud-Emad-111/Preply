<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use HasFactory;

    protected $fillable=[
        'day',
        'hour',
        'teacher_id',
    ];
    protected $casts=[
        'hour'=>'array',
    ];
    protected $hidden=[
        'created_at',
        'updated_at',
    ];
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

}
