@extends('layouts.login')

@section('content')
    <!-- フォローユーザー一覧 -->
    <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
        <p style="margin-left:25px;">Follow List</p>

        <ul style="display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach($followings as $following)
                <li style="list-style-type: none; display: flex; align-items: center;">
                    <a href="{{ route('users.show', $following->id) }}" style="display: flex; align-items: center; text-decoration: none; color: black;">
                        <img
                            src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                            alt="{{ $following->username }}'s Profile Image"
                            width="50" height="50"
                            style="border-radius: 50%;">
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- フォローユーザーの投稿 -->
    <hr>

    @foreach ($posts as $post)
        <div style="height: 125px;" class="post mb-4 border rounded p-3 bg-light">
            <!-- 投稿ヘッダー：アイコンと名前 -->
            <div class="post-header" style="display: flex; align-items: center; margin-bottom: 10px;">
                <a href="{{ route('users.show', $post->user->id) }}" style="display: flex; align-items: center; text-decoration: none; color: black;">
                    <img
                        src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                        alt="{{ $post->user->username }}'s Profile Image"
                        width="50" height="50"
                        style="border-radius: 50%;">
                    <span style="margin-left: 10px;">{{ $post->user->username }}</span>
                </a>
            </div>

            <!-- 投稿内容 -->
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $post->post }}</p>

            <!-- 投稿日時 -->
              <div class="post-date-top-right">
    <small>投稿日: {{ $post->created_at->diffForHumans() }}</small>
</div>


            <!-- 編集・削除ボタン（投稿者本人のみ表示） -->
            @if(Auth::check() && Auth::user()->id == $post->user_id)
                <div class="post-actions d-flex justify-content-end mt-2">
                    <button class="btn btn-warning js-modal-open me-2" data-id="{{ $post->id }}" data-content="{{ $post->post }}" style="background: none; border: none;">
                        <img src="{{ asset('images/edit.png') }}" alt="編集" style="width: 30px; height: 30px; border-radius: 5px;">
                    </button>
                    <button type="button" class="btn btn-danger js-delete-open" data-post-id="{{ $post->id }}" style="background: none; border: none;">
                        <img src="{{ asset('images/trash.png') }}" alt="削除" style="width: 20px; height: 20px; border-radius: 5px;">
                    </button>
                </div>
            @endif
        </div>
    @endforeach
@endsection
