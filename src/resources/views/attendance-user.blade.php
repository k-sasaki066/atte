@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-user.css') }}">
@endsection

@section('content')
<h2 class="user-date__header">
    {{ $display }} 現在
</h2>

<div class="user-table__container">
    <table class="user-table">
        <tr class="user-table__row">
            <th class="user-table__header">番号</th>
            <th class="user-table__header">ID</th>
            <th class="user-table__header">名前</th>
            <th class="user-table__header">メールアドレス</th>
            <th class="user-table__header">勤務状態</th>
            <th class="user-table__header">登録年月日</th>
            <th class="user-table__header"></th>
        </tr>

        @php
            $list_item =($users->currentPage()-1)*$users->perPage()+1;
        @endphp

        @foreach($users as $user)
        <tr class="user-table__row">
            <td class="user-table__item">
                {{ $list_item }}
            </td>
            <td class="user-table__item">
                {{ $user['id'] }}
            </td>
            <td class="user-table__item">
                {{ $user['name'] }}
            </td>
            <td class="user-table__item">
                {{ $user['email'] }}
            </td>
            <td class="user-table__item">
                @switch($user['status'])
                    @case(0)
                        未出勤
                        @break

                    @case(1)
                        出勤
                        @break

                    @case(2)
                        休憩
                        @break

                    @case(3)
                        退勤
                        @break

                    @default
                        その他
                @endswitch
            </td>
            <td class="user-table__item">
                {{ substr($user['created_at'], 0, 10) }}
            </td>
            <td class="user-table__item">
                <div class="user__btn-group">
                    <a class="user__edit-btn btn" href="">編集</a>
                    <a class="user__delete-btn btn" href="">削除</a>
                </div>
            </td>
        </tr>

        @php
            $list_item+=1;
        @endphp

        @endforeach
    </table>
</div>
<div class="pagination__group">
    {{ $users->links('vendor.pagination.custom') }}
</div>
@endsection
