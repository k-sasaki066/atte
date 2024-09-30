@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-date.css') }}">
@endsection

@section('content')
    <div class="content__inner">
        <form class="date-form" action="" method="">
            <button class="date-change__button"> < </button>
            <h2 class="date-form__header">
                2024-09-30
            </h2>
            <button class="date-change__button"> > </button>
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
                <tr class="date-table__row">
                    <td class="date-table__item">山田太郎</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                </tr>
                <tr class="date-table__row">
                    <td class="date-table__item">山田太郎</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                </tr>
                <tr class="date-table__row">
                    <td class="date-table__item">山田太郎</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                </tr>
                <tr class="date-table__row">
                    <td class="date-table__item">山田太郎</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                </tr>
                <tr class="date-table__row">
                    <td class="date-table__item">山田太郎</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                    <td class="date-table__item">08:30:00</td>
                </tr>
            </table>
        </div>
    </div>
@endsection