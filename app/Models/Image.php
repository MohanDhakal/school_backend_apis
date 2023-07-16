<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'image_url',
        'folder_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
