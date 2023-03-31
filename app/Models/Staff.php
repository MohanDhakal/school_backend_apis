<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Staff extends Model
{
    use HasFactory;

    protected $dateFormat = 'Y-m-d';

    public function subjects():HasMany
    {
        return $this->hasMany(Subject::class);
    }
    
}
