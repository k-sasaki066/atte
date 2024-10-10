@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/work-schedule.css') }}">
@endsection

@section('content')
    <h2 class="schedule-date__user">
        @php
            $user_name = $users->pluck('name')->first();
        @endphp
        {{ $user_name }}さんの勤怠表
    </h2>
    <div class="schedule-search__group">
        <form class="schedule-search__form" action="/schedule/search" method="get">
        @csrf
            <div class="schedule-date__search">
                <input type="hidden" name="display" value="{{ $display }}">
                <button class="schedule-change__button" name="previous-month"> < </button>
                <h2 class="schedule-form__header">
                    {{ substr($display, 0, 4).'年' .substr($display, 5, 2).'月' }}
                </h2>
                <button class="schedule-change__button" name="next-month"> > </button>
            </div>

            <div class="schedule-name__search">
                <input class="schedule-name__search-input" type="text" name="name" placeholder="名前を入力してください" value="{{ request('name') }}" >
                <input type="hidden" name="user_id" value="{{ $user_id }}">
                <input class="schedule-name__search-btn" type="submit" value="検索">
            </div>
        </form>
    </div>

<div class="schedule-table__container">
    <table class="schedule-table">
        <tr class="schedule-table__row">
            <th class="schedule-table__header">日付</th>
            <th class="schedule-table__header">勤務開始</th>
            <th class="schedule-table__header">勤務終了</th>
            <th class="schedule-table__header">休憩時間</th>
            <th class="schedule-table__header">実働時間</th>
        </tr>

        @foreach($periods as $date)
            <tr class="schedule-table__row">
                <td class="schedule-table__item">
                    {{ $date->isoFormat('MM月DD日(ddd)') }}
                </td>
                @foreach($users as $user)
                    @if($date->format('Y-m-d') == substr($user['work_start'], 0, 10))
                        <td class="schedule-table__item">
                            {{ substr($user['work_start'], 11, 8) }}
                        </td>
                        <td class="schedule-table__item">
                            {{ substr($user['work_end'], 11, 8) }}
                        </td>
                        <td class="schedule-table__item">
                            @if($user['total_rest'] == null)
                            ー
                            @else
                            {{ $user['total_rest'] }}
                            @endif
                        </td>
                        <td class="schedule-table__item">
                            @if($user['total_rest'] == null)
                            {{ $user['total_work'] }}
                            @else
                            {{ $user['actual_work'] }}
                            @endif
                        </td>
                    @else
                    @continue
                    @endif
                @endforeach
            </tr>
        @endforeach
    </table>
</div>
@endsection