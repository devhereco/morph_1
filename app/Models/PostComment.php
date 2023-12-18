<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content'
    ];

    protected static function boot()
    {
        parent::boot();

        self::creating(fn (PostComment $comment) => $comment->user_id = Auth::id());
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
