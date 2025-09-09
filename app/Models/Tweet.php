<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tweet extends Model
{
    /** @use HasFactory<\Database\Factories\TweetFactory> */
    use HasFactory;

    protected $fillable = ['tweet'];

    /**
     * 投稿者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このTweetに「いいね」したユーザー
     */
    public function liked(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
