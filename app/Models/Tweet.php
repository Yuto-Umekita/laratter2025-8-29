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
     * ���e��
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ����Tweet�Ɂu�����ˁv�������[�U�[
     */
    public function liked(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
