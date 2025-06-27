@extends('layouts.login')

@section('content')
<div class="followers-list">

    {{-- メッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 検索フォーム --}}
    <div class="search-container">
<form action="{{ route('followers.index') }}" method="GET"
    class="search-form d-flex align-items-center w-100"
    style="max-width: 900px; margin-bottom: 20px;">
    <input type="text" name="query" placeholder="ユーザー名"
        value="{{ request('query') }}"
        class="form-control mr-2"
        style="height: 50px; font-size: 18px;">

    <button type="submit" class="btn btn-secondary d-flex align-items-center justify-content-center"
        style="height: 50px; width: 50px; padding: 0; margin-left:25px;">
        <img src="{{ asset('images/search.png') }}" alt="検索"
            style="width: 35px; height: 35px; padding:5px;">
    </button>

    @if(request('query'))
        <p class="ml-3 mb-0">検索ワード: <strong>{{ request('query') }}</strong></p>
    @endif
</form>

<hr class="section-divider">
        @if($followers->isNotEmpty())
            <h3>検索結果</h3>
            <div class="follows-list">
                @foreach ($followers as $follower)
                    <div class="follower-item d-flex align-items-center mb-3">
                        {{-- 画像の割り当て：例としてIDを元にicon1〜7をローテーション --}}
                        @php
                            $iconNumber = ($follower->id % 7) + 1;
                        @endphp

                        {{-- プロフィール画像 --}}
                        <a href="{{ route('users.profile', $follower->id) }}" class="d-flex align-items-center">
<img src="{{ asset('images/' . $follower->profile_image) }}"
     alt="{{ $follower->username }}'s Profile Image"
     width="50" height="50"
     class="me-3 rounded-circle object-fit-cover"
     style="object-fit: cover;">
                        </a>

                        {{-- ユーザー名の表示（アイコンの横に配置） --}}
                        <div class="follower-name ml-2">
                            <p class="mb-0">{{ $follower->username }}</p>
                        </div>

                        {{-- フォローボタン --}}
                        @if (auth()->id() !== $follower->id)
                            <form action="{{ route('toggleFollow', $follower->id) }}" method="POST" class="d-inline ml-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ auth()->user()->followings->contains($follower->id) ? 'btn-following' : 'btn-not-following' }}">
                                    {{ auth()->user()->followings->contains($follower->id) ? 'フォロー解除' : 'フォロー' }}
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif(request('query'))
            <p>検索結果が見つかりませんでした。</p>
        @endif
    </div>
</div>
@endsection
