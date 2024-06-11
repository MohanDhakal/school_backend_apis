<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable=[
        'exam_type',// First Term, Second Term or Final      
        'academic_year',
        "started_at",
        "class_id"
    ];
}

