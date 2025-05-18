@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('review.css') }}">
@endsection

@section('content')

<div class="title">
        <div class="title1">STEM GATE</div>
        <div class="title2">企業データを活用して理工系女子の就職をワンストップでサポート</div>
</div>

<div class="container">
<h2>口コミ一覧</h2>

<!-- プルダウンで企業名選択 -->
<div class="form-container" style="margin: 2rem 0;">
    <form method="GET" action="{{ route('review') }}">
        <label for="comp_name">企業名を選択してください：</label>
        <select name="comp_name" id="comp_name" required>
            <option value="">--選択してください--</option>
            @foreach ($companies as $company)
                <option value="{{ $company->comp_name }}" {{ request('comp_name') === $company->comp_name ? 'selected' : '' }}>
                    {{ $company->comp_name }}
                </option>
            @endforeach
        </select>
        <button type="submit">検索</button>
    </form>
</div>
</div>


@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif

@if ($review && $review->isNotEmpty())
    @foreach($review as $reviews)
    <div class="review-card">
        <div class="review-header">
            <h3>
                {{ $reviews->name }} さん
            </h3>

            {{-- 自分以外のユーザーにだけ表示 --}}
            @if(Auth::check() && $reviews->user_id && Auth::id() !== $reviews->user_id)
                <form method="POST" action="{{ route('consult.request', ['to_user_id' => $reviews->user_id]) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="button-consult">相談する</button>
                </form>
            @endif

            <div class="review-rating">
                クチコミ総合評価 
                <span class="stars">
                    {{ str_repeat('★', $reviews->growth_potential) }}
                    {{ str_repeat('☆', 5 - $reviews->growth_potential) }}
                </span>
            </div>
        </div>

        <div class="review-details">
            回答者: {{ $reviews->employment_status }}／{{ $reviews->speciality }}／{{ $reviews->years_of_service }}／{{ $reviews->age_group }}／{{ $reviews->employment_type }}
        </div>

        <div class="review-comment">
            {{ $reviews->reviews }}
        </div>
    </div>

    @endforeach
@else
    <p>口コミデータがありません。</p>
@endif

<footer class="copyright">
        copyrights 2024 Wom-tech All Rights Reserved.
</footer>

@endsection
