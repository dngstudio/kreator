<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'featured_image', 'user_id'];

    // Define the relationship between Post and User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

