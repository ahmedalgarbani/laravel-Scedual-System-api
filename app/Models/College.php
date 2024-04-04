<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class College extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'name',
        'description',
    ];

    // Define a hasMany relationship with Department model
    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
