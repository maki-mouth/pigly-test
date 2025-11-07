@extends('layouts.header')

@section('css')
<link rel="stylesheet" href="{{ asset('css/log.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@section('content')
    <main class="main-content">
        <div class="summary-area">
            <div class="summary-card">
                <p class="summary-label">目標体重</p>
                <p class="summary-value">
                    {{ $goalWeight ?? '--' }}
                    <span class="unit">kg</span>
                </p>
            </div>

            <div class="summary-card">
                <p class="summary-label">目標まで</p>

                @php
                    // 差分が存在する場合のみ処理を実行
                    if ($difference !== null) {
                        // 目標までの絶対値
                        $diffValue = abs($difference);
                        // プラス値の場合 (目標達成まで減量が必要)
                        $diffClass = ($difference > 0) ? '' : 'negative-value';
                    } else {
                        $diffValue = '--';
                        $diffClass = '';
                    }
                @endphp

                <p class="summary-value {{ $diffClass }}">
                    {{ $diffValue }}
                    <span class="unit">kg</span>
                </p>
            </div>

            <div class="summary-card">
                <p class="summary-label">最新体重</p>
                <p class="summary-value">
                    {{ $latestWeight ?? '--' }}
                    <span class="unit">kg</span>
                </p>
            </div>
        </div>

        <div class="data-section">
            <div class="control-bar">
                <form class="date-search-form" method="GET" action="{{ route('log') }}">
                    <input type="date" name="start_date" class="date-select"
                        value="{{ request('start_date') }}">
                    <span class="date-separator">〜</span>
                    <input type="date" name="end_date" class="date-select"
                        value="{{ request('end_date') }}">
                    <button type="submit" class="search-button">検索</button>
                    @if (request('start_date') || request('end_date'))
                        <a href="{{ route('log') }}" class="reset-button">リセット</a>
                    @endif
                </form>
                <button type="button" id="open-modal-button" class="add-data-button">データ追加</button>
            </div>

            <div class="log-table-container">
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>日付</th>
                            <th>体重</th>
                            <th>食事摂取カロリー</th>
                            <th>運動時間</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($weightLogs as $log)
                        <tr>
                            {{-- 日付 --}}
                            <td>{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</td>
                            {{-- 体重 --}}
                            <td>{{ $log->weight }}<span class="unit-text">kg</span></td>
                            {{-- 食事摂取カロリー --}}
                            <td>{{ $log->calories }}<span class="unit-text">cal</span></td>
                            {{-- 運動時間 --}}
                            <td>{{ $log->exercise_time }}</td>
                            <td>
                                <a href="{{ route('detail', $log->id) }}" class="edit-icon"><i class="fas fa-pen"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="no-record-message">
                                まだ体重の記録がありません。
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ページネーションリンク --}}
            <div class="pagination-container">
                {{ $weightLogs->links() }}
            </div>
        </div>
    </main>

    <div id="add-log-modal" class="modal-overlay @if ($errors->any()) active @endif">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Weight Logを追加</h2>
                <button type="button" id="close-modal-button" class="close-button">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('store') }}" method="POST" class="log-form">
                @csrf

                <div class="form-group">
                    <label for="date">日付 <span class="required-tag">必須</span></label>
                    <input type="date" name="date" id="date" class="form-control"
                        value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    @error('date')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">体重 <span class="required-tag">必須</span></label>
                    <div class="input-group">
                        <input type="number" step="0.1" name="weight" id="weight" class="form-control" placeholder="50.0" value="{{ old('weight') }}">
                        <span class="input-unit">kg</span>
                    </div>
                    @error('weight')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="calories">摂取カロリー <span class="required-tag">必須</span></label>
                    <div class="input-group">
                        <input type="number" name="calories" id="calories" class="form-control" placeholder="1200" value="{{ old('calories') }}">
                        <span class="input-unit">cal</span>
                    </div>
                    @error('calories')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>運動時間 <span class="required-tag">必須</span></label>
                    <div class="input-group">
                        <input type="text" name="exercise_time" class="form-control time-input" placeholder="00:00" value="{{ old('exercise_time') }}">
                    </div>
                    @error('exercise_time')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="exercise_content">運動内容</label>
                    <textarea name="exercise_content" id="exercise_content" class="form-control" placeholder="運動内容を追記">{{ old('exercise_content') }}</textarea>
                    @error('exercise_content')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancel-button">閉じる</button>
                    <button type="submit" class="btn btn-primary">登録</button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- モーダル制御用 JavaScript --}}
    {{-- ============================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('add-log-modal');
            const openButton = document.getElementById('open-modal-button');
            const closeButton = document.getElementById('close-modal-button');
            const cancelButton = document.getElementById('cancel-button');

            // モーダルを開く
            if (openButton) {
                openButton.addEventListener('click', function() {
                    modal.classList.add('active');
                });
            }

            // モーダルを閉じる関数
            function closeModal() {
                modal.classList.remove('active');
                // URLからエラー情報を取り除く (モーダルが閉じた後にリロードしても開かないように)
                if (history.replaceState) {
                    history.replaceState({}, document.title, location.pathname);
                }
            }

            // 閉じるボタン
            if (closeButton) {
                closeButton.addEventListener('click', closeModal);
            }

            // キャンセルボタン（閉じるボタンと同じ動作）
            if (cancelButton) {
                cancelButton.addEventListener('click', closeModal);
            }

            // オーバーレイクリックで閉じる
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModal();
                    }
                });
            }
        });
    </script>

@endsection
