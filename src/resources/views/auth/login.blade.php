@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection


@section('content')
<div class="content__inner">
    <h2 class="content__header">ログイン</h2>
    
    <form class="form-group" action="/login" method="post">
        @csrf
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

        <button class="login-form__btn" type="submit">ログイン</button>
    </form>

    <div class="register-guide">
        <p class="register-guide__text">
            アカウントをお持ちでない方はこちらから
        </p>
        <a class="register-guide__btn" href="/register">
            会員登録
        </a>
    </div>
</div>
@endsection
