@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance-user.css') }}">
@endsection

@section('content')
<h2 class="user-date__header">
    {{ $display }} 現在
</h2>

<form class="user__search-form" action="/user/search" method="get">
    @csrf
    <input class="search-form__input id-input" type="text" name="user_id" placeholder="IDを入力してください" value="{{ request('user_id') }}">
    <input class="search-form__input keyword-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
    <div class="search-form__attendance">
        <select class="search-form__input attendance-select" name="status">
            <option selected disabled>選択してください</option>
            <option value="1" @if( request('status')==1 ) selected @endif>出勤</option>
            <option value="2" @if( request('status')==2 ) selected @endif>勤務中</option>
            <option value="3" @if( request('status')==3 ) selected @endif>休憩</option>
            <option value="4" @if( request('status')==4 ) selected @endif>退勤</option>
        </select>
    </div>
    <div class="search-form__actions">
        <input class="search-form__search-btn btn" type="submit" value="検索">
        <input class="search-form__reset-btn btn" type="submit" value="リセット" name="reset">
    </div>
</form>


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

        @if($users -> isEmpty())
            <tr class="user-table__row">
                <td class="user-table__item-empty" colspan="7">
                    該当データはありません
                </td>
            </tr>
        @else

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
                        @case(1)
                            出勤
                            @break

                        @case(2)
                            勤務中
                            @break

                        @case(3)
                            休憩
                            @break

                        @case(4)
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
        @endif
    </table>
</div>
<div class="pagination__group">
    {{ $users->appends(request()->query())->links('vendor.pagination.custom') }}
</div>
@endsection
