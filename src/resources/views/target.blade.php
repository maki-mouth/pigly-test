@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/target.css') }}">
@endsection

@section('content')
    <main class="main-content"> 
        
        <div class="card setting-card"> 
            <h2 class="page-title">目標体重設定</h2>
            
            <form action="" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group input-with-suffix target-input">
                    <div class="input-wrapper">
                        <input id="target_weight" type="number" name="target_weight" value="46.5" placeholder="目標体重を入力" step="0.1">
                        <span class="suffix">kg</span>
                    </div>
                </div>

                <div class="action-buttons-footer setting-footer">
                    <a href="{{ route('log') }}" class="back-button">戻る</a>
                    
                    <button type="submit" class="update-button">更新</button>
                </div>
            </form>
        </div>
    </main>
@endsection