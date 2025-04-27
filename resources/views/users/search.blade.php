@extends('layouts.login')

@section('content')
<div class="followers-list">
    <h1>{{ Auth::user()->name }} のフォロワー</h1>

    {{-- メッセージ --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 検索フォーム --}}
    <div class="search-container">
        <h2>ユーザー検索</h2>
        <form action="{{ route('followers.index') }}" method="GET" class="search-form d-flex align-items-center">
            <input type="text" name="query" placeholder="ユーザー名で検索" value="{{ request('query') }}" class="form-control">
            <button type="submit" class="btn btn-secondary btn-square">
                <img src="{{ asset('images/search.png') }}" alt="検索" style="width: 20px; height: 20px;">
            </button>
            @if(request('query'))
                <p class="ml-3 mb-0">検索ワード: <strong>{{ request('query') }}</strong></p>
            @endif
        </form>
        <hr>

        {{-- 検索結果 --}}
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
                        <a href="{{ route('users.profile', $follower->id) }}">
                            <img src="{{ asset('images/icon' . $iconNumber . '.png') }}" alt="{{ $follower->name }} のアイコン" class="rounded-circle mr-3" width="50" height="50">
                        </a>

                        <div>
                            <p class="mb-0">{{ $follower->name }}</p>

                            {{-- フォローボタン --}}
                            @if (auth()->id() !== $follower->id)
                                <form action="{{ route('toggleFollow', $follower->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ auth()->user()->followings->contains($follower->id) ? 'btn-primary' : 'btn-danger' }}">
                                        {{ auth()->user()->followings->contains($follower->id) ? 'フォロー解除' : 'フォロー' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif(request('query'))
            <p>検索結果が見つかりませんでした。</p>
        @endif
    </div>
</div>
@endsection
