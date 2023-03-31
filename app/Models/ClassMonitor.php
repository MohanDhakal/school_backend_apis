<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassMonitor extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function students()
    {
        return $this->belongsTo(Student::class);
    }

}
