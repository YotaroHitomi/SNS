@extends('layouts.login')

@section('content')
   <div class="container">

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
        @endforeach
    </div>

@endsection
