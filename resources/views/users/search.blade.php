@extends('layouts.login')

@section('content')
<div class="followers-list container py-4">

    {{-- 成功メッセージ --}}
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    {{-- 検索フォーム --}}
    <form action="{{ route('followers.index') }}" method="GET"
          class="search-form d-flex align-items-center mb-2"
          style="max-width: 900px;">
        <input type="text" name="query" placeholder="ユーザー名"
               value="{{ request('query') }}"
               class="form-control me-2"
               style="height: 50px; font-size: 18px;">

        <button type="submit" class="btn btn-secondary d-flex align-items-center justify-content-center"
                style="height: 50px; width: 50px; padding: 0;">
            <img src="{{ asset('images/search.png') }}" alt="検索"
                 style="width: 35px; height: 35px; padding:5px;">
        </button>
    </form>

    {{-- 検索ワード表示 --}}
    @if(request('query'))
        <p class="mb-3">検索ワード: <strong>{{ request('query') }}</strong></p>
    @endif

    <hr class="section-divider">

    {{-- ユーザー一覧の表示 --}}
    @if($users->isNotEmpty())
        <div class="follows-list">
            @foreach ($users as $user)
                <div class="follower-item d-flex align-items-center mb-3">

                    {{-- プロフィール画像 --}}
                    <a href="{{ route('users.profile', $user->id) }}" class="d-flex align-items-center me-3">
<img src="{{ asset('images/' . $user->images) }}"
     alt="{{ $user->username }} のプロフィール画像"
     width="60" height="60"
     style="border-radius: 50%; object-fit: cover;">
                    </a>

                    {{-- ユーザー名 --}}
                    <div class="follower-name me-auto">
                        <p class="mb-0 fs-5">{{ $user->username }}</p>
                    </div>

                    {{-- フォロー/フォロー解除ボタン --}}
                    @if (auth()->id() !== $user->id)
                        <form action="{{ route('toggleFollow', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            @php
                                $isFollowing = auth()->user()->followings->contains($user->id);
                            @endphp
                            <button type="submit"
                                    class="btn {{ $isFollowing ? 'btn-following' : 'btn-not-following' }}">
                                {{ $isFollowing ? 'フォロー解除' : 'フォロー' }}
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <p>ユーザーが見つかりませんでした。</p>
    @endif

</div>

{{-- フォローボタンのスタイル --}}
<style>
.btn-following {
    background-color: #dc3545; /* Bootstrapの赤 */
    color: white;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 6px;
}
.btn-following:hover {
    background-color: #c82333;
    color: white;
}

.btn-not-following {
    background-color: #007bff; /* Bootstrapの青 */
    color: white;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 6px;
}
.btn-not-following:hover {
    background-color: #0069d9;
    color: white;
}
</style>
@endsection
