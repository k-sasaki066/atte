@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection


@section('content')
<div class="content__inner">
    <h2 class="content__header">会員登録</h2>
    
    <form class="form-group" action="/register" method="post">
        @csrf
        <div class="form-group__item">
            <input class="form-group__input" type="text" name="name" placeholder="名前" value="{{ old('name') }}">
            <div class="error-message">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group__item">
            <input class="form-group__input" type="text" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
            <div class="error-message">
                @error('email')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group__item">
            <input class="form-group__input" type="password" name="password" placeholder="パスワード" value="">
            <div class="error-message">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>

        <div class="form-group__item">
            <input class="form-group__input" type="password" name="password_confirmation" placeholder="確認用パスワード" value="">
            <div class="error-message">
                @error('password_confirmation')
                {{ $message }}
                @enderror
            </div>
        </div>

        <button class="register-form__btn" type="submit">会員登録</button>
    </form>

    <div class="login-guide">
        <p class="login-guide__text">
            アカウントをお持ちの方はこちらから
        </p>
        <a class="login-guide__btn" href="/login">
            ログイン
        </a>
    </div>
</div>
@endsection
