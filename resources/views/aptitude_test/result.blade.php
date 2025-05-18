@extends('layouts.app')

@section('head')
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('aptitude_result.css') }}">
@endsection

@section('content')
<div class="result-wrapper">
    <div class="title">
        <div class="title1">STEM GATE</div>
        <div class="title2">企業データを活用して理工系女子の就職・就業をワンストップでサポート</div>
    </div>

    <div class="result-container">
        <h2 class="result-heading">診断結果</h2>
        <p class="result-subtitle">
            あなたの診断結果は　
            <span class="result-type">{{ $type ?? '未分類' }}</span>　タイプです
        </p>

        {{-- 結果画像 --}}
        <div class="result-image">
            <img src="{{ asset('images/types/' . ($imageFile ?? 'default.png')) }}" alt="{{ $type }}">
        </div>

        {{-- 自然文結果 --}}
        <div class="result-text">
            {!! nl2br(e($reason ?? '診断理由が取得できませんでした。')) !!}
        </div>

        {{-- 推奨情報 --}}
        <div class="recommendation">
            <p><strong>おすすめの業種：</strong>{{ $industry ?? 'ー' }}</p>
            <p><strong>おすすめの職種：</strong>{{ $job ?? 'ー' }}</p>
        </div>

        <div class="result-button-wrapper">
            <a href="{{ route('comps_database') }}" class="result-button">おすすめ業種の企業一覧はこちら</a>
        </div>
    </div>

    <footer class="copyright">
        copyrights 2024 Wom-tech All Rights Reserved.
    </footer>
</div>
@endsection
