<?php

namespace App\Http\Controllers;

use App\Models\ConsultationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * 相談リクエスト送信
     */
    public function sendRequest($to_user_id)
    {
        // 重複チェック
        $exists = ConsultationRequest::where('from_user_id', Auth::id())
                    ->where('to_user_id', $to_user_id)
                    ->where('approved', false)
                    ->exists();

        if ($exists) {
            return back()->with('error', 'すでにこのユーザーに相談リクエストを送信済みです。');
        }

        ConsultationRequest::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $to_user_id,
        ]);

        return back()->with('success', '相談リクエストを送信しました');
    }

    /**
     * 自分宛の相談リクエスト一覧を表示
     */
    public function received()
    {
        $requests = ConsultationRequest::with('fromUser')
                        ->where('to_user_id', Auth::id())
                        ->get();

        return view('consult.received', compact('requests'));
    }

    /**
     * リクエスト承認処理
     */
    public function approve($id)
    {
        $request = ConsultationRequest::findOrFail($id);

        // 本人のリクエスト以外は403
        if ($request->to_user_id !== Auth::id()) {
            abort(403);
        }

        $request->approved = true;
        $request->save();

        return redirect()->route('consult.received')->with('success', '相談を承認しました。');
    }
}
