<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User; 

class Tweet extends Model
{
    /** @use HasFactory<\Database\Factories\TweetFactory> */
    use HasFactory;

    protected $fillable = ['tweet'];

      public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }
    /**
     * ���e��
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ����Tweet�Ɂu�����ˁv�������[�U�[
     */
    public function liked()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

        public function bookmarkedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }
}
