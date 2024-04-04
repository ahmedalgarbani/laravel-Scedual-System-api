<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department_lecturer extends Model
{
    use HasFactory;


    protected $fillable=['lecturer_id','department_id'];
    protected $table="department_lecturer";
}
