<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'views',
        'likes',
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(fn(Post $post) => $post->user_id = Auth::id());
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class);
    }
}
