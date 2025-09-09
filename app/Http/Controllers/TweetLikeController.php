<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet; // �� �ǉ�

class TweetLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * �u�����ˁv����
     */
    public function store(Tweet $tweet)
    {
        // ���ɂ����˂��Ă��Ȃ��ꍇ�̂ݒǉ��i�d���h�~�j
        if (! $tweet->liked()->where('user_id', auth()->id())->exists()) {
            $tweet->liked()->attach(auth()->id());
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * �u�����ˁv���O��
     */
    public function destroy(Tweet $tweet)
    {
        $tweet->liked()->detach(auth()->id());
        return back();
    }
}
