<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        @if(Auth::check())
        <nav class="header-right">
            <ul class="header-nav__list">
                <li class="header-nav__item">
                    <a href="" class="header-nav__link">
                        ホーム
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="" class="header-nav__link">
                        日付一覧
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
    </header>

    <main class="content">
        @yield('content')
    </main>

    <footer class="footer">
        <small class="footer-text">Atte,inc</small>
    </footer>
</body>
</html>