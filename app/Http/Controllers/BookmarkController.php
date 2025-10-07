<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    // ← __construct と $this->middleware('auth') は削除

    public function index(Request $request)
    {
        $tweets = $request->user()->bookmarks()
            ->with(['user'])
            ->latest('bookmarks.created_at')
            ->paginate(20);

        return view('tweets.bookmarks', compact('tweets'));
    }

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
