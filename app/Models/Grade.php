<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'grade';
    protected $primaryKey='class_id';
    protected $fillable=[
        'class_num',
        'class_name'
    ];
}
