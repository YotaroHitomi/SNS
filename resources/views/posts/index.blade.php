@extends('layouts.login')

@section('content')
TOPページ
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
                <div class="d-flex align-items-center w-100">
                    <img src="{{ asset('images/icon1.png') }}" alt="User Icon">

                    <textarea name="post" class="form-control" placeholder="投稿内容を入力してください" required style="border: none; border-radius: 25px; height: 150px; width: 70%;"></textarea>

<button type="submit" class="btn btn-primary ms-2" style="width: 60px; height: 60px; padding: 0; border-radius: 10px; align-items: center; justify-content: center; border: none;">
    <i class="fas fa-paper-plane" style="font-size: 24px;"></i>
</button>
                </div>
            @endguest
        </div>
        <hr>
    {!! Form::close() !!}

    <!-- フォローしているユーザーの投稿のみ表示 -->
    <div class="container">
        @foreach ($posts as $post)
            <div style="width: 560px; min-height: 150px;" class="post mb-4 border rounded p-3 bg-light">
                <div class="post-header d-flex align-items-center mb-2">
                    <a href="{{ route('users.show', $post->user->id) }}" class="d-flex align-items-center text-decoration-none text-dark">
                        <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}"
                             alt="{{ $post->user->name }}'s Profile Image" width="50" height="50" class="me-3 rounded-circle">
                        <strong>{{ $post->user->name }}</strong>
                    </a>
                </div>
                <p class="mt-2">{{ $post->post }}</p>

                <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>

                @if(Auth::check() && Auth::user()->id == $post->user_id)
                    <div class="post-actions d-flex justify-content-end">
                        <button class="btn btn-warning js-modal-open me-2" data-id="{{ $post->id }}" data-content="{{ $post->post }}" style="background: none; border: none;">
                            <img src="{{ asset('images/edit.png') }}" alt="編集" style="width: 30px; height: 30px; border-radius: 5px;">
                        </button>

                        <!-- 削除ボタン：モーダル表示 -->
                        <button type="button" class="btn btn-danger js-delete-open" data-post-id="{{ $post->id }}" style="background: none; border: none;">
                            <img src="{{ asset('images/trash.png') }}" alt="削除" style="width: 20px; height: 20px; border-radius: 5px;">
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
<img src="{{ asset('images/edit.png') }}" alt="編集" style="width: 30px; height: 30px; border-radius: 5px;">
</form>
            </div>
        </div>
    </div>
</div>

<!-- 削除確認モーダル -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">削除の確認</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                本当にこの投稿を削除しますか？
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">削除</button>
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
        right: 10px;
        display: flex;
        gap: 10px;
    }

    .modal.fade .modal-dialog {
        position: fixed;
        bottom: 0;
        right: 0;
        margin: 20px;
    }

    .modal-dialog.modal-lg {
        max-width: 50%;
    }

    .modal-body {
        padding: 20px;
    }

    #postContent {
        height: 250px;
        font-size: 16px;
    }

    .js-modal-open img,
    .js-delete-open img {
        object-fit: cover;
        border-radius: 5px;
    }
</style>
@endsection
