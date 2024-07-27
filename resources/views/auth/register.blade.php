@extends('layouts.logout')

@section('content')
<!-- 適切なURLを入力してください -->
<div class="text-content">
{!! Form::open(['url' => '/register']) !!}

<h2>新規ユーザー登録</h2>
@if ($errors->has('username'))
  <span class="invalid-feedback" role="alert">
    {{ $errors->first('username') }}
  </span>
@endif
<br>
{{ Form::label('ユーザー名') }}
{{ Form::text('username',null,['class' => 'input']) }}
<br>
@if ($errors->has('mail'))
  <span class="invalid-feedback" role="alert">
    {{ $errors->first('mail') }}
  </span>
@endif
<br>
{{ Form::label('メールアドレス') }}
{{ Form::text('mail',null,['class' => 'input']) }}
<br>
@if ($errors->has('password'))
  <span class="invalid-feedback" role="alert">
    {{ $errors->first('password') }}
  </span>
@endif
<br>
{{ Form::label('パスワード') }}
{{ Form::text('password',null,['class' => 'input']) }}
<br>
{{ Form::label('パスワード確認') }}
{{ Form::text('password_confirmation',null,['class' => 'input']) }}

{{ Form::submit('登録') }}

<p><a href="/login">ログイン画面へ戻る</a></p>

{!! Form::close() !!}


@endsection

</div>
