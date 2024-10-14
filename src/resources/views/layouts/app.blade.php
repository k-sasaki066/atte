<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>Atte</title>
</head>

<body>
    <header class="header">
        <div class="header-left">
            <h1 class="header-text">Atte</h1>
        </div>

        <div id="drawer_toggle">
			<span></span>
			<span></span>
			<span></span>
		</div>

        @if(Auth::check())
        <nav class="header-right" id="header-nav">
            <ul class="header-nav__list">
                <li class="header-nav__item">
                    <a href="/" class="header-nav__link">
                        ホーム
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="/attendance" class="header-nav__link">
                        日付一覧
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="/user" class="header-nav__link">
                        ユーザー一覧
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="/schedule" class="header-nav__link">
                        勤怠表
                    </a>
                </li>
                <li class="header-nav__item">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="header-nav__link" type="submit">
                            ログアウト
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        @endif
        <script src="{{ asset('js/nav.js') }}"></script>
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer class="footer">
        <small class="footer-text">Atte,inc</small>
    </footer>
</body>
</html>