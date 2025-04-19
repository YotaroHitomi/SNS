@extends('layouts.login')

@section('content')
<div class="followers-list">
    <h1>{{ Auth::user()->name }} のフォロワー</h1>

    <!-- メッセージの表示 -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- フォロワー検索フォーム -->
    <div class="search-container">
        <h2>ユーザー検索</h2>
        <form action="" method="GET" class="search-form d-flex align-items-center">
            <input type="text" name="query" placeholder="ユーザー名で検索" value="{{ request('query') }}" class="form-control">
            <button type="submit" class="btn btn-secondary btn-square">
                <img src="{{ asset('images/search.png') }}" alt="検索アイコン" style="width: 20px; height: 20px;">
            </button>

            @if(request('query'))
                <p class="ml-3 mb-0">検索ワード: <strong>{{ request('query') }}</strong></p>
            @endif
        </form>
        <hr>

        @if(isset($followers) && $followers->isNotEmpty())
            <h3>検索結果</h3>
            <div class="follows-list">
                @foreach ($followers as $follower)
                    <div class="follower-item">
                        <a href="{{ route('users.profile', $follower->id) }}">
                            <img src="{{ asset('storage/' . ($follower->profile_image ?? 'default-profile.png')) }}" alt="{{ $follower->username }} のアイコン" class="follower-icon">
                        </a>
                        <p>{{ $follower->username }}</p>
                        <p class="text-muted small">{{ $follower->name }}</p> {{-- name追加 --}}
                        @if (auth()->id() !== $follower->id)
                            @if (auth()->user()->followings->contains($follower->id))
                                <form action="{{ route('toggleFollow', $follower->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">フォロー解除</button>
                                </form>
                            @else
                                <form action="{{ route('toggleFollow', $follower->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary">フォロー</button>
                                </form>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @elseif(request('query'))
            <p>検索結果が見つかりませんでした。</p>
        @endif
    </div>

    <!-- 自分がフォローしているユーザーの一覧 -->
    <div class="following-list mt-5">
        <h2>{{ Auth::user()->username }} のフォロー中ユーザー</h2>
        <div class="follows-list">
            @foreach (auth()->user()->followings as $follow)
                <div class="follower-item">
                    <a href="{{ route('users.profile', $follow->id) }}">
                        @php
                            $icons = ['icon1.png', 'icon2.png', 'icon3.png', 'icon4.png', 'icon5.png', 'icon6.png', 'icon7.png'];
                            $randomIcon = $icons[array_rand($icons)];
                        @endphp
                        <img src="{{ asset('images/' . $randomIcon) }}" alt="{{ $follow->username }} のアイコン" class="follower-icon">
                    </a>
                    <p>{{ $follow->username }}</p>
                    <p class="text-muted small">{{ $follow->name }}</p> {{-- name追加 --}}
                    @if (auth()->id() !== $follow->id)
                        @if (auth()->user()->followings->contains($follow->id))
                            <form action="{{ route('toggleFollow', $follow->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger">フォロー解除</button>
                            </form>
                        @else
                            <form action="{{ route('toggleFollow', $follow->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">フォロー</button>
                            </form>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
