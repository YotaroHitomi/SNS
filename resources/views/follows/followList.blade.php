@extends('layouts.app')

@section('content')
    <h1>{{ $user->name }}がフォローしているユーザー</h1>

    @if ($following->isEmpty())
        <p>フォローしているユーザーはいません。</p>
    @else
        <ul>
            @foreach ($following as $followed)
                <li>
                    <a href="{{ route('user.profile', $followed->id) }}">
                        {{ $followed->name }}のプロフィール
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
        <h1>{{ $user->name }}のプロフィール</h1>

    <p>Email: {{ $user->email }}</p>
    <p>登録日: {{ $user->created_at->format('Y-m-d') }}</p>

    <!-- フォロー/アンフォローボタンを表示 -->
    @if (auth()->user()->isFollowing($user))
        <form action="{{ url('/unfollow/' . $user->id) }}" method="POST">
            @csrf
            <button type="submit">アンフォロー</button>
        </form>
    @else
        <form action="{{ url('/follow/' . $user->id) }}" method="POST">
            @csrf
            <button type="submit">フォロー</button>
        </form>

        <h1>Follow Users</h1>

<ul>
    @foreach ($followedUsers as $followedUser)
        <li>{{ $followedUser->name }}</li>
    @endforeach
</ul>



@if (auth()->user()->isNotFollowing($user))
    <form action="{{ route('follow', $user->id) }}" method="POST">
        @csrf
        <button type="submit">Follow</button>
    </form>
@else
    <form action="{{ route }}"></form>

    @if (auth()->user()->isNotFollowing($user))
    <form action="{{ route('follow', $user->id) }}" method="POST">
        @csrf
        <button type="submit">Follow</button>
    </form>
@else
    <form action="{{ route('unfollow', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Unfollow</button>
    </form>
@endif
    @endif
@endsection
