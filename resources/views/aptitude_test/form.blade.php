@extends('layouts.app')

@section('content')
    <div class="title">
        <div class="title1">STEM GATE</div>
        <div class="title2">企業データを活用して理工系女子の就職をワンストップでサポート</div>
    </div>

    <div class="main-wrapper">
        <div class="container">
            <h2 class="question-title">質問 {{ $currentStep }} / {{ $totalSteps }}</h2>

            <form method="POST" action="{{ $isLast ? route('aptitude_test.submit') : route('aptitude_test.next') }}">
                @csrf
                <input type="hidden" name="step" value="{{ $currentStep }}">
                <p class="question-title">{{ $question['text'] }}</p>

                @if($question['type'] === 'text')
                    <textarea name="answer" required class="aptitude-button" rows="3">{{ old('answer') }}</textarea>

                    <div class="mt-4 text-center">
                        <button type="submit" class="aptitude-button">次へ進む</button>
                    </div>
                @elseif($question['type'] === 'radio')
                <div class="options-wrapper">
                        @foreach($question['options'] as $value => $label)
            <button type="submit" name="answer" value="{{ $value }}" class="aptitude-button">
                {{ $label }}
            </button>
        @endforeach

                @endif
            </form>
        </div>
    </div>
    </div>
    <footer class="copyright">
        copyrights 2024 Wom-tech All Rights Reserved.
    </footer>
@endsection

