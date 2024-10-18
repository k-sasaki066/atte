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
            <option value="" selected disabled>選択してください</option>
            <option value="1" @if( request('status')==1 ) selected @endif>出勤</option>
            <option value="2" @if( request('status')==2 ) selected @endif>勤務中</option>
            <option value="3" @if( request('status')==3 ) selected @endif>休憩</option>
            <option value="4" @if( request('status')==4 ) selected @endif>退勤</option>
            <option value="5" @if( request('status')==5 ) selected @endif>その他</option>
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
                        <a class="user__edit-btn btn" href="#{{ $user->id }}">編集</a>
                        <a class="user__delete-btn btn" href="#delete{{ $user->id }}">削除</a>
                    </div>
                </td>
            </tr>

            <div class="modal-edit" id="{{$user->id}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal-edit__inner">
                    <a href="#" class="modal__close-btn">×</a>
                    <h3 class="modal-edit__header">
                        ユーザー情報編集
                    </h3>
                    <form class="modal-edit__form" action="/user" method="post">
                    @method('PATCH')
                    @csrf
                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                ID
                            </label>
                            <span class="modal-edit__text">
                                {{ $user['id'] }}
                            </span>
                            <input type="hidden" name="id" value="{{ $user['id'] }}">
                        </div>

                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                名前
                            </label>
                            <input class="modal-edit__input" type="text" name="name" value="{{ $user['name'] }}">
                        </div>

                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                メールアドレス
                            </label>
                            <input class="modal-edit__input" type="text" name="email" value="{{ $user['email'] }}">
                        </div>
                        <button class="modal-edit__button" type="submit">
                            更新
                        </button>
                    </form>
                </div>
            </div>

            <div class="modal-delete" id="delete{{$user->id}}">
                <a href="#!" class="modal-overlay"></a>
                <div class="modal-delete__inner">
                    <a href="#" class="modal__close-btn">×</a>
                    <h3 class="modal-edit__header">
                        このユーザーを削除します。<br>
                        よろしいですか？
                    </h3>
                    <form class="modal-edit__form" action="/user/search" method="post">
                        @method('DELETE')
                        @csrf
                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                ID
                            </label>
                            <span class="modal-edit__text">
                                {{ $user['id'] }}
                            </span>
                            <input type="hidden" name="id" value="{{ $user['id'] }}">
                        </div>

                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                名前
                            </label>
                            <span class="modal-edit__text">
                                {{ $user['name'] }}
                            </span>
                        </div>

                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                メールアドレス
                            </label>
                            <span class="modal-edit__text">
                                {{ $user['email'] }}
                            </span>
                        </div>

                        <div class="modal-edit__group">
                            <label for="" class="modal-edit__label">
                                登録年月日
                            </label>
                            <span class="modal-edit__text">
                                {{ substr($user['created_at'], 0, 10) }}
                            </span>
                        </div>
                        <button class="modal-edit__button delete-btn" type="submit">
                            削除
                        </button>
                    </form>
                </div>
            </div>
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
