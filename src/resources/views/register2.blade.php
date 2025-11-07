@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register2.css') }}">
@endsection

@section('content')
    <h2 class="title">新規会員登録</h2>

    <p class="step">STEP 2. 体重データの入力</p>

    <form action="{{ route('register2.post') }}" method="POST">
        @csrf

        <div class="form-group input-with-suffix">
            <label for="current_weight">現在の体重</label>
            <div class="input-wrapper">
                <input id="current_weight" type="number" name="current_weight" placeholder="現在の体重を入力" step="0.1" value="{{ old('current_weight') }}">
                <span class="suffix">kg</span>
            </div>
            @error('current_weight')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>


        <div class="form-group input-with-suffix">
            <label for="target_weight">目標の体重</label>
            <div class="input-wrapper">
                <input id="target_weight" type="number" name="target_weight" placeholder="目標の体重を入力" step="0.1" value="{{ old('target_weight') }}">
                <span class="suffix">kg</span>
            </div>
            @error('target_weight')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="action-buttons">
            <button type="submit" class="create-button">アカウント作成</button>
        </div>

    </form>
@endsection