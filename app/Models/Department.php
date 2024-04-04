<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Department extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'name',
        'description',
        'code',
        'college_id', // Foreign key referencing College
    ];

    // Define a belongsTo relationship with College model (optional)
    public function college()
    {
        return $this->belongsTo(college::class);
    }
    // app/Models/Department.php

    public function lecturers()
    {

        return $this->belongsToMany(Lecturer::class);
    }

}
