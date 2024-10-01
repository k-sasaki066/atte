@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="content__inner">
        <h2 class="content__header">{{ Auth::user()->name }}さんお疲れ様です!</h2>
        <form class="attendance-form__group" action="" method="">
            <button class="work-form__submit" type="submit" name="">
                勤務開始
            </button>

            <button class="work-form__submit" type="submit" name="">
                勤務終了
            </button>

            <button class="work-form__submit" type="submit" name="">
                休憩開始
            </button>

            <button class="work-form__submit" type="submit" name="">
                休憩終了
            </button>
        </form>
    </div>
@endsection

