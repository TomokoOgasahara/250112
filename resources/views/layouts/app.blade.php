<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>STEM GATE - 適職診断</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- フォント --}}
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700&display=swap" rel="stylesheet">

    {{-- Vite ビルドCSS（必要な場合のみ） --}}
    @vite('resources/css/app.css')

    {{-- 共通CSS --}}
    <link rel="stylesheet" href="{{ asset('aptitude_test.css') }}">

    {{-- 各ページごとの追加CSS（呼び出し元のファイルで @section('head') ... @endsection を定義） --}}
    @yield('head')
</head>

<body class="bg-gray-100">
    @yield('content')
</body>
</html>
