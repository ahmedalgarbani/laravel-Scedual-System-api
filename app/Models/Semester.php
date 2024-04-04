<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Semester extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
    ];


}
