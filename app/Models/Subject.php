<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    public $timestamps = false;
  
    protected $primaryKey='subject_id';

    protected $fillable=[
        'staff_id',
        'subject_name',
        'of_grade',
        'course_id',    
        'class_id',
        'sub_code',
        'TH_W',
        'IN_W',
        'total_credit'   
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
