@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/log.css') }}">
@endsection

@section('content')
    <main class="main-content">
        <div class="summary-area">
            <div class="summary-card">
                <p class="summary-label">目標体重</p>
                <p class="summary-value"><span class="unit">kg</span></p>
            </div>
            <div class="summary-card">
                <p class="summary-label">目標まで</p>
                <p class="summary-value negative-value"><span class="unit">kg</span></p>
            </div>
            <div class="summary-card">
                <p class="summary-label">最新体重</p>
                <p class="summary-value"><span class="unit">kg</span></p>
            </div>
        </div>

        <div class="data-section">
            <div class="control-bar">
                <form class="date-search-form">
                    <select name="start_year" class="date-select"><option>年/月/日</option></select>
                    <span class="date-separator">〜</span>
                    <select name="end_year" class="date-select"><option>年/月/日</option></select>
                    <button type="submit" class="search-button">検索</button>
                </form>
                <a href="" class="add-data-button">データ追加</a>
            </div>

            <div class="log-table-container">
                <table class="log-table">
                    <thead><tr><th>日付</th><th>体重</th><th>食事摂取カロリー</th><th>運動時間</th><th></th></tr></thead>
                    <tbody>
                        @for ($i = 0; $i < 8; $i++)
                        <tr>
                            <td>2023/11/{{ 26 - $i }}</td>
                            <td>46.5<span class="unit-text">kg</span></td>
                            <td>1200<span class="unit-text">cal</span></td>
                            <td>00:15</td>
                            <td><a href="" class="edit-icon"><i class="fas fa-pen"></i></a></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                <span class="page-link disabled">&lt;</span>
                <span class="page-link active">1</span>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <span class="page-link disabled">&gt;</span>
            </div>
        </div>
    </main>
@endsection
