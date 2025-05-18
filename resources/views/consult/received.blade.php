@extends('layouts.app')

@section('content')
<h2>あなたへの相談リクエスト</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@forelse($requests as $req)
    <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
        <p><strong>{{ $req->fromUser->name }}</strong> さんから相談リクエストがあります。</p>

        @if($req->approved)
            <p style="color: green;">✅ 承認済み</p>
            <p>連絡先メールアドレス：<strong>{{ $req->fromUser->email }}</strong></p>
        @else
            <form method="POST" action="{{ route('consult.approve', $req->id) }}">
                @csrf
                <button type="submit">承認する</button>
            </form>
        @endif
    </div>
@empty
    <p>まだ相談リクエストは届いていません。</p>
@endforelse
@endsection
