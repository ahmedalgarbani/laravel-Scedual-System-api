<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Subject extends Model
{
    use HasFactory,HasApiTokens;
    // app/Models/Subject.php
    protected $fillable = [
        'name',
        'short_name',
        'description',
        'hour',
        'department_id',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function lecturers()
    {
        return $this->belongsToMany(Lecturer::class,'subject_lecturer');
    }
    // app/Models/Subject.php

    public function timetables()
    {
        return $this->hasMany(timestable::class);
    }


}
