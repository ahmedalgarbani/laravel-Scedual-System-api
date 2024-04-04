<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Timestable extends Model
{
    use HasFactory;
   use HasApiTokens;
    // app/Models/Timetable.php
    protected $fillable = [
        'subject_id',
        'lecturer_id',
        'room_id',
        'start_time',
        'end_time',
        'day',
        'semester_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
    public function classroom()
    {
        return $this->belongsTo(room::class);
    }
    public function semester()
    {
        return $this->belongsTo(semester::class);
    }


}
