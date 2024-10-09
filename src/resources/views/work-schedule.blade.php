@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/work-schedule.css') }}">
@endsection

@section('content')
<form class="schedule-form" action="/schedule/month" method="get">
    @csrf
    <button class="schedule-change__button" name="previous-month"> < 前月 </button>
    <input type="hidden" name="display" value="{{ $display }}">
    <h2 class="schedule-form__header">
        {{ substr($display, 0, 4).'年' .substr($display, 5, 2).'月' }}
    </h2>
    <button class="schedule-change__button" name="next-month"> 翌月 > </button>
</form>

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