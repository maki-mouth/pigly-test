@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register1.css') }}">
@endsection

@section('content')
    <h2 class="title">新規会員登録</h2>
    <p class="step">STEP 1. アカウント情報の登録</p>

    <form  class="form-container" action="/register/step1" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">お名前</label>
            <input id="name" type="text" name="name" placeholder="名前を入力" value="{{ old('name') }}">
        </div>
        
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" placeholder="メールアドレスを入力" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="パスワードを入力">
        </div>

        <div class="action-buttons">
            <button type="submit" class="next-button">次に進む</button>
            <a href="" class="login-link">ログインはこちら</a>
        </div>
    </form>
@endsection