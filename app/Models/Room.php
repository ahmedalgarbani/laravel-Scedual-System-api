<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Room extends Model
{
    use HasFactory,HasApiTokens;
    // app/Models/Classroom.php
    protected $fillable = [
        'name',
        'capacity', // ... other attributes
        'location',
        'department_id', // Added attribute
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function timetables()
    {
        return $this->hasMany(timestable::class);
    }

}
