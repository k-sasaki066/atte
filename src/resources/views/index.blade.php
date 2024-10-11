@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content__inner">
    @if($status == 4)
        <h2 class="content__header">
            本日もお疲れ様でした。
        </h2>
    @else
        <h2 class="content__header">
            {{ Auth::user()->name }}さんお疲れ様です!
        </h2>
    @endif

    <form class="attendance-form__group" action="/" method="post">
        @csrf
        <button class="attendance-form__submit" type="submit" name="work_start" {{$status == 1 ? '' : 'disabled'}}>
            勤務開始
        </button>

        <button class="attendance-form__submit" type="submit" name="work_end"
        {{$status == 2 ? '' : 'disabled'}}>
            勤務終了
        </button>

        <button class="attendance-form__submit" type="submit" name="rest_start"
        {{$status == 2 ? '' : 'disabled'}}>
            休憩開始
        </button>

        <button class="attendance-form__submit" type="submit" name="rest_end"
        {{$status == 3 ? '' : 'disabled'}}>
            休憩終了
        </button>
    </form>
</div>
@endsection

