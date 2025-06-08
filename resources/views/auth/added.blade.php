@extends('layouts.logout')

@section('content')

<div class="text-content">
  <div id="clear">

    @if(session('registered_username'))
      <p class="msg">
        {{ session('registered_username') }}さん
      </p>
    @endif

    <p style="margin-bottom: 20px;">ようこそ！AtlasSNSへ！</p>
    <p>ユーザー登録が完了しました。</p>
    <p style="margin-bottom: 40px;">早速ログインをしてみましょう。</p>

    <p class="btn" style="margin-top: 30px;">
      <a href="/login" style="
        background-color: red;
        color: white;
        padding: 12px 25px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
      ">
        ログイン画面へ
      </a>
    </p>

  </div>
</div>

@endsection
