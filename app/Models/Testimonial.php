<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'current_status',
        'address',
        'message',
        'current_rank',
        'is_active',
        'image_uri'
    ];
}
