<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentContact extends Model
{
    use HasFactory;
    protected $table = 'std_contact';
    protected $primaryKey='contact_id';
    protected $fillable=[
        'student_id',
        'phone_number',
        'guardian_contact_number',
        'email',
    ];
}
