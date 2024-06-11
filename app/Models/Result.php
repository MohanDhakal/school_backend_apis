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
    protected $fillable=[
        'exam_id',
        'student_id',
        'subject_id',
        'marks_type', //theory or internal 
        'marks',
        'grade'//calculate it using th_w or in_w
    ];
}
