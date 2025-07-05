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
        <div class="d-flex align-items-center w-100" style="position: relative;">
            {{-- ユーザーアイコン --}}
            <img src="{{ asset('images/' . Auth::user()->profile_image) }}" alt="User Icon"
                style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-right: 10px; margin-top: 10px ; margin-bottom:-130px;">

@if ($errors->any())
    <div class="alert alert-danger error-box">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@else
    <div class="error-box" style="visibility: hidden;">&nbsp;</div>
@endif

            {{-- テキストエリア --}}
            <textarea name="post"
                      class="form-control @error('post') is-invalid @enderror"
                      placeholder="投稿内容を入力してください"
                      style="border: none; border-radius: 25px; height: 125px; width: 60%; padding: 15px 20px; font-size: 16px; resize: none; margin-left:120px;">{{ old('post') }}</textarea>

            {{-- 投稿ボタン --}}
            <button type="submit" class="btn btn-primary ms-2"
                style="width: 60px; height: 60px; border-radius: 10px; border: none; position: absolute; bottom: 0; left: 75%;">
                <img src="/images/post.png" alt="Post" style="width: 50px; height: 50px;">
            </button>
        </div>
            @endguest
        </div>
    <hr class="section-divider">
    {!! Form::close() !!}

    <!-- フォローしているユーザーの投稿のみ表示 -->
    <div class="container">
@foreach ($posts as $post)
    @php
        $isOwnPost = Auth::check() && Auth::user()->id === $post->user_id;
    @endphp
    <div style="height: {{ $isOwnPost ? '200px' : '125px' }};" class="post mb-4 border rounded p-3 bg-light">
<div class="d-flex align-items-center text-dark">
    <img src="{{ asset('images/' . $post->user->profile_image) }}"
         alt="{{ $post->user->username }}'s Profile Image"
         width="50" height="50" class="me-3 rounded-circle">
    <strong class="username">{{ $post->user->username }}</strong>
</div>
        <p class="mt-2">{{ $post->post }}</p>

        <div class="post-date-top-right">
            <small class="post-date">{{ $post->created_at->format('Y-m-d H:i') }}</small>
        </div>

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
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="
      background-color: #fff;
      padding: 20px;
      border: 1.5px solid #ccc;
      border-radius: 12px;
      width: 100%;
      box-sizing: border-box;
      position: relative;
    ">
      <form id="editForm" method="POST" action="{{ route('posts.update', '0') }}">
        @csrf
        @method('PUT')

        <div class="modal-body" style="padding: 0;">
          <textarea id="postContent"
                    name="post"
                    class="form-control"
                    required
                    placeholder="投稿内容を編集してください..."
                    style="
                      width: 100%;
                      height: 300px;
                      font-size: 18px;
                      padding: 15px;
                      border: 1px solid #ddd;
                      border-radius: 8px;
                      background-color: #fff;
                      resize: none;
                      box-sizing: border-box;
                      margin-bottom: 20px;
                    "></textarea>
        </div>

<div class="modal-footer" style="border-top: none; padding-top: 0; padding-bottom: 0; text-align: center; width: 100%;">
  <div style="display: inline-block;">
    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
      <img src="{{ asset('images/edit.png') }}" alt="更新" style="width: 40px; height: 40px;">
    </button>
  </div>
</div>

      </form>
    </div>
  </div>
</div>

<!-- 削除確認モーダル -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-sm custom-delete-modal" style="margin: 0 auto;">
        <div class="modal-content rounded-4" style="background-color: transparent; box-shadow: none;">
            <div class="modal-header" style="background-color: #fff; border: none; border-radius: 8px 8px 0 0;">
            </div>
<div class="modal-body text-center" style="background-color: #fff; padding: 10px 15px; border:none;">
    この投稿を削除します。よろしいでしょうか？
</div>
<div class="modal-footer d-flex justify-content-center" style="background-color: #fff; border:none; border-radius: 0 0 8px 8px; gap: 10px; padding: 10px 0;">
    <form id="deleteForm" method="POST" action="" style="display: flex; gap: 10px;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger px-4 py-2">OK</button>
        <button type="button" class="btn btn-secondary px-4 py-2 js-cancel-delete">キャンセル</button>
    </form>
</div>
        </div>
    </div>
</div>

<style>
#deleteConfirmModal .modal-footer form {
    display: flex;
    gap: 10px;
    margin: 0;
    width: auto;
}

#deleteConfirmModal .modal-footer .btn {
    width: 120px;
    height: 45px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 6px;
}

#deleteConfirmModal .modal-footer .btn-danger {
    background-color: #186AC9;
    color: #fff;
    border: none;
    margin-right: -73px;
}

#deleteConfirmModal .modal-footer .btn-secondary {
    background-color: #fff;
    border: 2px solid #000;
    color: #000;
    margin-right: 15px;
}

    /* フェードインアニメーション */
    #deleteConfirmModal.fade .modal-dialog {
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    #deleteConfirmModal.show .modal-dialog {
        opacity: 1;
    }

        #deleteConfirmModal .modal-dialog {
        margin: 0 auto !important;
        max-width: 400px;
    }

</style>

<script>
document.querySelectorAll('.js-modal-open').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const postId = this.dataset.id;
        const postContent = this.dataset.content;
        document.getElementById('postContent').value = postContent;
        document.getElementById('editForm').action = `/posts/${postId}`;

        const editModalEl = document.getElementById('editModal');
        const editModal = new bootstrap.Modal(editModalEl);
        editModal.show();
    });
});

    document.querySelectorAll('.js-delete-open').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            document.getElementById('deleteForm').action = `/posts/${postId}`;
            const deleteModalEl = document.getElementById('deleteConfirmModal');

            // Bootstrapのモーダルインスタンスを作成
            const deleteModal = new bootstrap.Modal(deleteModalEl);

            // 表示前にopacityを0にしておく（念のため）
            deleteModalEl.querySelector('.modal-dialog').style.opacity = 0;

            // モーダルを表示
            deleteModal.show();

            // 少し遅延を入れてopacityを1に（フェードイン効果）
            setTimeout(() => {
                deleteModalEl.querySelector('.modal-dialog').style.opacity = 1;
            }, 10);
        });
    });


    document.querySelectorAll('.js-cancel-delete').forEach(button => {
        button.addEventListener('click', function () {
            const deleteModalElement = document.getElementById('deleteConfirmModal');
            const modalInstance = bootstrap.Modal.getInstance(deleteModalElement);
            if(modalInstance) {
                modalInstance.hide();
            }
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
        gap: 15px;
    }

    .post-actions button {
        margin: 0;
        padding: 0;
        background: none;
        border: none;
    }

/* 削除モーダルの位置を上部中央に調整 */
#deleteConfirmModal .modal-dialog {
    margin-top: 5vh !important;   /* 上から5%の位置 */
    margin-left: auto !important;
    margin-right: auto !important;
    max-width: 400px;             /* 必要に応じて幅調整 */
    background-color: transparent !important; /* ここは残してOK */
}

/* モーダルコンテンツは白背景・影あり */
#deleteConfirmModal .modal-content {
    background-color: #fff !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    border-radius: 8px !important;
    border: none !important;
}

/* ヘッダーのみ上角丸 */
#deleteConfirmModal .modal-header {
    border-radius: 8px 8px 0 0;
    border: none;
    background-color: #fff;
    padding: 15px 20px;
}

/* ボディは角丸なし */
#deleteConfirmModal .modal-body {
    border-radius: 0;
    border: none;
    background-color: #fff;
    padding: 20px;
}

/* フッターは下角丸 */
#deleteConfirmModal .modal-footer {
    border-radius: 0 0 8px 8px;
    border: none;
    background-color: #fff;
    padding: 15px 20px;
}


/* 編集モーダルの中央表示と幅調整 */
#editModal .modal-dialog {
    display: flex;
    align-items: center;
    min-height: 100vh;
    max-width: 900px;   /* 最大幅を狭める */
    margin: 0 auto;     /* 横中央 */
}

/* モーダルコンテンツの幅を100%にしつつmax-widthに合わせる */
#editModal .modal-content {
    width: 100%;
    box-sizing: border-box;
    background-color: #fff;
    padding: 20px;
    border-radius: 12px;
    border: 1.5px solid #ccc;
}


    .custom-delete-modal {
        z-index: 1055;
    }

    #deleteConfirmModal .modal-content {
        background-color: #fff;
    }
</style>
@endsection
