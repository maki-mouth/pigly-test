@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register1.css') }}">
@endsection

@section('content')
    <h2 class="title">新規会員登録</h2>

    <p class="step">STEP 1. アカウント情報の登録</p>
        <!-- ★★★ このエリアが必須です ★★★ -->
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <!-- ★★★ ここまで ★★★ -->


    <form action="{{ route('register1.post') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">お名前</label>
            <input id="name" type="text" name="name" placeholder="名前を入力" value="{{ old('name') }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" placeholder="メールアドレスを入力" value="{{ old('email') }}">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="パスワードを入力">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="action-buttons">
            <button type="submit" class="next-button">次に進む</button>
            <a href="{{ route('login') }}" class="login-link">ログインはこちら</a>
        </div>
    </form>
@endsection