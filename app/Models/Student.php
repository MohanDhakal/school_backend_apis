<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey='student_id';
    protected $dateFormat = 'Y-m-d';
    protected $fillable=[
        'full_name',
        'dob',
        'grade',
        'address',
        'guardian_contact',
        'email',
        'current_rank',
        'joined_at',
        'image_uri',
        'major_subject',
        'is_active',
        'roll_number'
    ];

}
