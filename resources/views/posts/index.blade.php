@extends('layouts.login')

@section('content')
<div class="container mt-3">
    {!! Form::open(['route' => 'posts.store', 'method' => 'POST']) !!}
        {{ csrf_field() }}
        <div class="row mb-4">
            @guest
        <div class="mx-auto">
            <a class="btn btn-primary" href="{{ route('login') }}">ログインしてツイートする</a>
            <a class="btn btn-primary" href="{{ route('register') }}">新規登録してツイートする</a>
        </div>
    @else
<div class="d-flex align-items-center w-100" style="position: relative;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{-- ユーザーアイコン --}}
            <img src="{{ asset('images/icon1.png') }}" alt="User Icon"
                style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 10px; margin-top: 10px">

            {{-- テキストエリア --}}
            <textarea name="post"
                      class="form-control @error('post') is-invalid @enderror"
                      placeholder="投稿内容を入力してください"
                      style="border: none; border-radius: 25px; height: 125px; width: 60%; padding: 15px 20px; font-size: 16px; resize: none;">{{ old('post') }}</textarea>

            {{-- 投稿ボタン --}}
            <button type="submit" class="btn btn-primary ms-2"
                style="width: 60px; height: 60px; border-radius: 10px; border: none; position: absolute; bottom: 0; left: 70%;">
                <img src="/images/post.png" alt="Post" style="width: 50px; height: 50px;">
            </button>
        </div>
    @endguest
</div>
<hr>

{!! Form::close() !!}
    <!-- フォローしているユーザーの投稿のみ表示 -->
    <div class="container">
@foreach ($posts as $post)
    @php
        $isOwnPost = Auth::check() && Auth::user()->id === $post->user_id;
    @endphp
    <div style="height: {{ $isOwnPost ? '200px' : '125px' }};" class="post mb-4 border rounded p-3 bg-light">
        <div class="post-header d-flex align-items-center mb-2">
            @if ($post->user)
                <a href="{{ route('users.show', $post->user->id) }}" class="d-flex align-items-center text-decoration-none text-dark">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="{{ asset('images/' . $post->user->profile_image) }}"
     alt="{{ $post->user->username }}'s Profile Image"
     width="50" height="50" class="me-3 rounded-circle">

<strong class="username">{{ $post->user->username }}</strong>

                </a>
            @else
                <p>ユーザー情報がありません</p>
            @endif
        </div>

        <p class="mt-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $post->post }}</p>

        <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>

        @if($isOwnPost)
<div class="post-actions d-flex align-items-center" style="gap: 0; padding: 0; margin: 0;">
    <button class="js-modal-open"
            data-id="{{ $post->id }}"
            data-content="{{ $post->post }}"
            style="background: none; border: none; padding: 0; margin: 0;">
        <img src="{{ asset('images/edit.png') }}" alt="編集"
             style="width: 25px; height: 25px;">
    </button>
<button type="button"
            class="delete-btn js-delete-open"
            data-post-id="{{ $post->id }}">
        <img src="{{ asset('images/trash.png') }}" alt="削除" style="width: 25px; height: 25px;">
    </button>
</div>
        @endif
    </div>
@endforeach

    </div>
</div>

<!-- BootstrapのJS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- 編集モーダル -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">

            <div class="modal-body">
<form id="editForm" method="POST" action="{{ route('posts.update', '0') }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <textarea id="postContent" name="post" class="form-control" required style="border-radius: 25px; height: 250px; width: 100%;"></textarea>
    </div>
<div class="d-flex justify-content-end">
    <button type="submit" class="btn btn-primary" style="background: none; border: none;">
        <img src="{{ asset('images/edit.png') }}" alt="更新" style="width: 30px; height: 30px; border-radius: 5px;">
    </button>
</div>
</form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">削除の確認</h5>
            </div>
            <div class="modal-body text-center">
                本当にこの投稿を削除しますか？
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between w-100">
                        <button type="submit" class="btn btn-danger px-4 py-2 me-2">OK</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    // 編集モーダル表示
    document.querySelectorAll('.js-modal-open').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const postId = this.dataset.id;
            const postContent = this.dataset.content;
            document.getElementById('postContent').value = postContent;
            document.getElementById('editForm').action = `/posts/${postId}`;
            const myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        });
    });

    // 削除確認モーダル表示
    document.querySelectorAll('.js-delete-open').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            document.getElementById('deleteForm').action = `/posts/${postId}`;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();
        });
    });
</script>

<style>
    .post-date {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 12px;
        color: #6c757d;
    }

    .post {
        position: relative;
    }

 .post-actions {
    position: absolute;
    bottom: 10px;
    right: 25px;
    display: flex;
    gap: 15px; /* ← ここでしっかり間隔を取る */
}

.post-actions button {
    margin: 0;
    padding: 0;
    background: none;
    border: none;
}
    .modal.fade .modal-dialog {
        position: fixed;
        bottom: 0;
        right: 0;
        margin: 20px;
    }

    .modal-dialog.modal-lg {
        max-width: 90%;
    }

    .modal-body {
        padding: 20px;
    }

 #postContent {
    width: 100%;
    height: 300px;
    font-size: 18px;
    padding: 15px;
    border-radius: 20px;
    resize: none; /* ユーザーによるサイズ変更を無効にする場合 */
    border: 1px solid #ccc;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

    .js-modal-open img,
    .js-delete-open img {
        object-fit: cover;
        border-radius: 5px;
    }
</style>
@endsection
