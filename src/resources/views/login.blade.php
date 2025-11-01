@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <h2 class="page-title">ログイン</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" placeholder="名前を入力" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="名前を入力" required>
            @error('password')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="action-buttons">
            <button type="submit" class="login-button">ログイン</button>
            <a href="{{ route('register1') }}" class="register-link">アカウント作成はこちら</a>
        </div>
    </form>
@endsection