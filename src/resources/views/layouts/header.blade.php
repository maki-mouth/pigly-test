<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PiGLy</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('css')
</head>

<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo-text">PiGLy</div>
            <nav class="header-nav">
                <a href="{{ route('target') }}" class="setting-link" title="目標体重設定">
                    <i class="fas fa-cog"></i> 目標体重設定
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">ログアウト</button>
                </form>
            </nav>
        </div>
    </header>

    @yield('content')

</body>
</html>
