@extends('layouts.login')

@section('content')
   <!-- <div class="container">

        <form action="/search" method="post">
           @csrf
           <input type="text" name="keyword" class="form" placeholder="タイトルで検索">
           <button type="submit" class="btn btn-success">検索</button>
        </form>

        <h2 class="page-header">本のリスト一覧</h2>
        <table class="table table-hover">
            <tr>
                <th>No</th>
                <th>タイトル</th>
                <th>著者名</th>
                <th>金額</th>
                <th>登録日時</th>
                <th></th>
            </tr>
        </table>

        @foreach ($posts as $post)
            <div class="mb-1">
                <strong>{{ $post->name }}</strong> {{ $post->created_at }}
            </div>
            <div class="pl-3">
                {{ $post->post }}
            </div>

            <button type="submit" class="btn btn-primary">フォローする</button>
        <hr>
        @endforeach -->

    </div>
        <div class="followers-list">
        @foreach ($follows as $follow)
            <div class="follower-item">
                <img src="{{ asset('storage/' . $follower->profile_image) }}" alt="{{ $follower->name }} のアイコン" class="follower-icon">
                <p>{{ $follower->name }}</p>

                @if (auth()->id() !== $follower->id)
                    @if ($isFollowing && $isFollowing->contains($follower->id))
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
        <h1>{{ $user->name }} のフォロワー</h1>

    <div class="followers-list">
        @foreach($followers as $follower)
            <div class="follower-item">
                <!-- フォロワーのアイコンと名前を表示 -->
                <a href="{{ route('user.profile', $follower->id) }}">
                    <img src="{{ asset('storage/' . $follower->profile_image) }}" alt="{{ $follower->name }} のアイコン" class="follower-icon">
                </a>
                <p>{{ $follower->name }}</p>
            </div>
        @endforeach
    </div>
@endsection
