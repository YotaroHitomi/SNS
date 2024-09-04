@extends('layouts.login')

@section('content')
        <form action="/search" method="post">
           @csrf
           <input type="text" name="keyword" class="form" placeholder="タイトルで検索">
           <button type="submit" class="btn btn-success">検索</button>
        </form>

@endsection
