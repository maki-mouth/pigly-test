@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <main class="main-content">
        <div class="card log-card">
            <h1 class="page-title">Weight Log</h1>

            <form action="{{ route('update', $log->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="date">日付</label>
                    <input id="date" type="date" name="date" class="date-select-field" 
                        value="{{ old('date', $log->date) }}">
                    @error('date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group input-with-suffix">
                    <label for="weight">体重</label>
                    <div class="input-wrapper">
                        <input id="weight" type="number" name="weight" 
                            value="{{ old('weight', $log->weight) }}" 
                            placeholder="体重を入力" step="0.1">
                        <span class="suffix">kg</span>
                    </div>
                    @error('weight')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group input-with-suffix">
                    <label for="calories">摂取カロリー</label>
                    <div class="input-wrapper">
                        <input id="calories" type="number" name="calories"
                            value="{{ old('calories', $log->calories) }}"
                            placeholder="カロリーを入力">
                        <span class="suffix">cal</span>
                    </div>
                    @error('calories')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exercise_time">運動時間</label>
                    <input type="text" id="exercise_time" name="exercise_time" placeholder="00:00" value="{{ old('exercise_time', $log->exercise_time) }}" step="60">
                    @error('exercise_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exercise_content">運動内容</label>
                    <textarea id="exercise_content" name="exercise_content" rows="4" placeholder="運動内容を追加">{{ old('exercise_content', $log->exercise_content) }}</textarea>
                    @error('exercise_content')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="action-buttons-footer">
                    <a href="{{ route('log') }}" class="back-button">戻る</a>

                    <button type="submit" class="update-button">更新</button>

                    <button type="button" class="delete-button" onclick="if(confirm('本当にこのログを削除しますか？')){ document.getElementById('delete-form').submit(); }">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </form>

            <form id="delete-form" action="{{ route('destroy', $log->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </main>
@endsection