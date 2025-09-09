<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet; // ← 追加

class TweetLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * 「いいね」する
     */
    public function store(Tweet $tweet)
    {
        // 既にいいねしていない場合のみ追加（重複防止）
        if (! $tweet->liked()->where('user_id', auth()->id())->exists()) {
            $tweet->liked()->attach(auth()->id());
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 「いいね」を外す
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->liked()->detach(auth()->id());
        return back();
    }
}
