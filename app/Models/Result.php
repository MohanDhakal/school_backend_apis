<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
         /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timestamps = false;

     protected $fillable=[
        'student_id',        
        'academic_year',
        'term',
        'subject_id',
        'full_marks',
        'pass_marks',
        'obtained_marks',
        'remarks',
        'grade'
    ];
}
