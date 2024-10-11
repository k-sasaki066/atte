@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-date.css') }}">
@endsection

@section('content')
<div class="content__inner">
    <form class="date-form" action="/attendance/date" method="get">
        @csrf
        <button class="date-change__button" name="previous-day"> < </button>
        <input type="hidden" name="display" value="{{ $display }}">
        <h2 class="date-form__header">
            {{ $display }}
        </h2>
        <button class="date-change__button" name="next-day"> > </button>
    </form>

    <div class="date-table__container">
        <table class="date-table">
            <tr class="date-table__row">
                <th class="date-table__header">名前</th>
                <th class="date-table__header">勤務開始</th>
                <th class="date-table__header">勤務終了</th>
                <th class="date-table__header">休憩時間</th>
                <th class="date-table__header">勤務時間</th>
            </tr>

            @if($users -> isEmpty())
                <tr class="date-table__row">
                    <td class="date-table__item-empty" colspan="5">
                        該当データはありません
                    </td>
                </tr>
            @else
                @foreach($users as $user)
                    <tr class="date-table__row">
                        <td class="date-table__item">
                            {{ $user['name'] }}
                        </td>
                        <td class="date-table__item">
                            {{substr($user['work_start'], 11, 8) }}
                        </td>
                        <td class="date-table__item">
                            {{substr($user['work_end'], 11, 8) }}
                        </td>
                        <td class="date-table__item">
                            @if($user['total_rest'] == null)
                            ー
                            @else
                            {{ $user['total_rest'] }}
                            @endif
                        </td>
                        <td class="date-table__item">
                            @if($user['total_rest'] == null)
                            {{ $user['total_work'] }}
                            @else
                            {{ $user['actual_work'] }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

    <div class="pagination__group">
        {{ $users->appends(['display'=>$display])->links('vendor.pagination.custom') }}
    </div>
</div>
@endsection