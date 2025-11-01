@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="card log-card">
            <h1 class="page-title">Weight Log</h1>

            <form action="" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="date">日付</label>
                    <select id="date" name="date" class="date-select-field">
                        <option value="2024-01-01" selected>2024年1月1日</option>
                        </select>
                </div>

                <div class="form-group input-with-suffix">
                    <label for="weight">体重</label>
                    <div class="input-wrapper">
                        <input id="weight" type="number" name="weight" value="50.0" placeholder="体重を入力" step="0.1">
                        <span class="suffix">kg</span>
                    </div>
                </div>

                <div class="form-group input-with-suffix">
                    <label for="calories">摂取カロリー</label>
                    <div class="input-wrapper">
                        <input id="calories" type="number" name="calories" value="1200" placeholder="カロリーを入力">
                        <span class="suffix">cal</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exercise_time">運動時間</label>
                    <input id="exercise_time" type="time" name="exercise_time" value="00:00" step="1">
                </div>

                <div class="form-group">
                    <label for="exercise_content">運動内容</label>
                    <textarea id="exercise_content" name="exercise_content" rows="4" placeholder="運動内容を追加"></textarea>
                </div>

                <div class="action-buttons-footer">
                    <a href="{{ route('log') }}" class="back-button">戻る</a>

                    <button type="submit" class="update-button">更新</button>

                    <button type="button" class="delete-button" onclick="document.getElementById('delete-form').submit()">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </form>

            <form id="delete-form" action="" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </main>
@endsection