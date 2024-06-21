<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $dateFormat = 'Y-m-d';
    protected $table = 'exam';
    protected $fillable=[
        'type',// First Term, Second Term or Final      
        'academic_year',
        "start_date",
        "class_id"
    ];
}

