<?php

namespace App\Models;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
