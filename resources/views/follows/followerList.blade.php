@extends('layouts.app')

@section('content')
    <h1>{{ $user->name }}のフォロワー</h1>

    @if ($followers->isEmpty())
        <p>フォロワーはまだいません。</p>
    @else
        <ul>
            @foreach ($followers as $follower)
                <li>
                    <a href="{{ route('user.profile', $follower->id) }}">
                        {{ $follower->name }}のプロフィール
                    </a>
                </li>
            @endforeach
        </ul>

        <h1>Followed Users</h1>

<ul>
    @foreach ($followedUsers as $followedUser)
        <li>{{ $followedUser->name }}</li>
    @endforeach
</ul>

@if (auth()->user()->isNotFollowed($user))
    <form action="{{ route('follow', $user->id) }}" method="POST">
        @csrf
        <button type="submit">Follow</button>
    </form>
@else
    <form action="{{ route }}"></form>

    @if (auth()->user()->isNotFollowed($user))
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
