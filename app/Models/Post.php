<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    //by casting body can be automatically encoded and decoded
    //without calling jsonencode and decode
    protected $casts=[
        'body'=>'array',
        'slugs'=>'array'
    ];
    protected $primaryKey='post_id';

    
 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable=[
        'user_id',
        'title',
        'body',
        'cover_image',
        'slugs'

    ];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
