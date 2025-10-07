<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 一覧（マイページの隣に出す「ブックマーク」）
    public function index(Request $request)
    {
        $tweets = $request->user()->bookmarks()
            ->with(['user'])
            ->latest('bookmarks.created_at')
            ->paginate(20);

        return view('tweets.bookmarks', compact('tweets'));
    }

    // 追加/解除トグル
    public function toggle(Request $request, Tweet $tweet)
    {
        $user = $request->user();

        if ($user->bookmarks()->where('tweet_id', $tweet->id)->exists()) {
            $user->bookmarks()->detach($tweet->id);
            return back()->with('status', 'ブックマークを解除しました');
        } else {
            $user->bookmarks()->attach($tweet->id);
            return back()->with('status', 'ブックマークに追加しました');
        }
    }
}
