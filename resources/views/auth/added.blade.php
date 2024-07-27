@extends('layouts.logout')

@section('content')

<div class="text-content">
<div id="clear">

  @if(session('msg'))
<p class="msg">
{{ session('msg') }}さん
</p>
@endif
  <p>ようこそ！AtlasSNSへ！</p>
  <p>ユーザー登録が完了しました。</p>
  <p>早速ログインをしてみましょう。</p>

  <p class="btn"><a href="/login">ログイン画面へ</a></p>
</div>

@endsection

</div>
