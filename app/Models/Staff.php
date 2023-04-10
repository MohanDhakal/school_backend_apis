<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Staff extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable=[
        'full_name',
        'dob',
        'level',
        'address',
        'phone_number',
        'email',
        'post',
        'rank',
        'major_in',
        'joined_at',
        'image_uri',
        'job_type',
        'is_active'
    ];
    public function subjects():HasMany
    {
        return $this->hasMany(Subject::class);
    }
    
}
