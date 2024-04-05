<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Lecturer extends Model
{
    use HasFactory,HasApiTokens;
    // app/Models/Lecturer.php

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    // app/Models/Lecturer.php
    protected $fillable = [
        'name',
        'address',
        'specialization',
        'description',
        'department_id',
    ];
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }


}
