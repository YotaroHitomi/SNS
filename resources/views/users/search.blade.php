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
        <form action="{{ route('followers.index') }}" method="GET" class="search-form d-flex align-items-center">
            <input type="text" name="query" placeholder="ユーザー名で検索" value="{{ request('query') }}" class="form-control">
            <button type="submit" class="btn btn-secondary btn-square">
                <img src="{{ asset('images/search.png') }}" alt="検索アイコン" style="width: 20px; height: 20px;">
            </button>

            @if(request('query'))
                <p class="ml-3 mb-0">検索ワード: <strong>{{ request('query') }}</strong></p>
            @endif
        </form>
        <hr>

        <!-- 検索結果 -->
        @if($followers->isNotEmpty())
            <h3>検索結果</h3>
            <div class="follows-list">
                @foreach ($followers as $follower)
                    <div class="follower-item">
                        <a href="{{ route('users.profile', $follower->id) }}">
                            <img src="{{ asset('images/icon' . rand(1, 7) . '.png') }}" alt="{{ $follower->name }} のアイコン" class="follower-icon">
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
</div>
@endsection
