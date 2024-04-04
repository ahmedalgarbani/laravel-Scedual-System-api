<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer_subject extends Model
{
    use HasFactory;
    protected $fillable=['subject_id','lecturer_id'];

    protected $table="lecturer_subject";
}
