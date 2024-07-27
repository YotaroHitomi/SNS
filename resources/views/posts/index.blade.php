@extends('layouts.login')

@section('content')


    <div class="container">



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="container">
          <!-- <form action="/search" method="post">
           @csrf
           <input type="text" name="keyword" class="form" placeholder="タイトルで検索">
           <button type="submit" class="btn btn-success">検索</button>
        </form> -->
          <p class="pull-right"><a class="btn btn-success" href="/top">登録する</a></p>

        <!-- <a href="/login"><h1>Laravelを使ったCRUD機能の実装</h1></a>

        <h2 class="page-header">本のリスト一覧</h2>
        <table class="table table-hover"> -->

        <!-- <div class="container">
        <h2 class="page-header">著者を登録する</h2>
        {!! Form::open(['url' => '/posts/index']) !!}
        <div class="form-group">
            {{ Form::input('text', 'authorName', null, ['required', 'class' => 'form-control', 'placeholder' => '著者名']) }}
        </div>
        <button type="submit" class="btn btn-success pull-right">登録</button>
        {!! Form::close() !!}
</div>
<div class="container">
    <h2 class="page-header">本を登録する</h2>
       <div class="form-group">
            <form action="/posts/index" method="post">
            @csrf
            <select class="form-select" aria-label="Default select example" name="author_id">
                <option value="">著者を選択してください。</option>

            </select>
            <input type="text" name="title" value="" class="form-control" placeholder="本のタイトル" required>
            <input type="text" name="price" value="" class="form-control" placeholder="本の金額" required>
            <button type="submit" class="btn btn-success pull-right">登録</button>
            </form>
       </div> -->

    <div class="container">
        <table class="table table-hover">
            <tr>
                <th>No</th>
                <th>タイトル</th>
                <th>著者名</th>
                <th>金額</th>
                <th>登録日時</th>
            </tr>
            @foreach ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->user->name }}/td>
                <td>{{ $post->price }}</td>
                <td>{{ $post->created_at }}</td>
                <td><a class="btn btn-primary" href="/top">更新</a></td>
                <td><a class="btn btn-danger" href="/top">削除</a></td>
            </tr>
            @endforeach
        </table>
    <!-- </div>
        <div class="container">
        <h2 class='page-header'>本のタイトルや金額を変更する</h2>
        {!! Form::open(['url' => '/posts/update']) !!}

        <button type="submit" class="btn btn-primary pull-right">更新</button>
        {!! Form::close() !!}
    </div> -->
    <!-- <footer>
        <small>Laravel@test.curriculum</small>
    </footer> -->
</body>

</html>



<!-- {!! Form::open(['url' => '/author/create']) !!}
     <div class="form-group">
         {{ Form::input('text', 'authorName', null, ['required', 'class' => 'form-control', 'placeholder' => '著者名']) }}
     </div>
     <button type="submit" class="btn btn-success pull-right">追加</button>
 {!! Form::close() !!} -->

<?php

    // <div class="container">
    //     <h2 class="page-header">著者を登録する</h2>
    //     {!! Form::open(['url' => '/author/create']) !!}
    //     <div class="form-group">
    //         {{ Form::input('text', 'authorName', null, ['required', 'class' => 'form-control', 'placeholder' => '著者名']) }}
    //     </div>
    //     <button type="submit" class="btn btn-success pull-right">追加</button>
    //     {!! Form::close() !!}
    // </div>




// ?>

@endsection
