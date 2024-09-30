@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection


@section('content')
    <div class="content__inner">
        <h2 class="content__header">会員登録</h2>
        <form class="form-group" action="" method="">
            <div class="form-group__item">
                <input class="form-group__input" type="text" name="name" placeholder="名前" value="">
                <div class="error-message">
                    エラー
                </div>
            </div>

            <div class="form-group__item">
                <input class="form-group__input" type="text" name="email" placeholder="メールアドレス" value="">
                <div class="error-message">
                    エラー
                </div>
            </div>

            <div class="form-group__item">
                <input class="form-group__input" type="text" name="password" placeholder="パスワード" value="">
                <div class="error-message">
                    エラー
                </div>
            </div>

            <div class="form-group__item">
                <input class="form-group__input" type="text" name="password_confirmation" placeholder="確認用パスワード" value="">
                <div class="error-message">
                    エラー
                </div>
            </div>

            <button class="register-form__btn" type="submit">会員登録</button>
        </form>

        <div class="login-guide">
            <p class="login-guide__text">
                アカウントをお持ちの方はこちらから
            </p>
            <a class="login-guide__btn" href="">
                ログイン
            </a>
        </div>
    </div>
@endsection
