<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
class Student extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'name',
        'registration_number',
        'address',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // ... other methods
}
