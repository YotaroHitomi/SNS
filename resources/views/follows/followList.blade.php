@extends('layouts.login')

@section('content')
    <div class="container">

        <form action="/search" method="post">
           @csrf
           <input type="text" name="keyword" class="form" placeholder="タイトルで検索">
           <button type="submit" class="btn btn-success">検索</button>
        </form>

        <p class="pull-right"><a class="btn btn-success" href="/create-form">登録する</a></p>

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
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post>id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->author->name }}</td>
                <td>{{ $post>price }}</td>
                <td>{{ $post->created_at }}</td>
                <td><a class="btn btn-primary" href="/post/{{$post->id}}/update-form">更新</a></td>
                <td><a class="btn btn-danger" href="/post/{{$post->id}}/delete" onclick="return confirm('こちらの本を削除してもよろしいでしょうか？')">削除</a></td>
            </tr>
            @endforeach
        </table>
    </div>
@endsection
