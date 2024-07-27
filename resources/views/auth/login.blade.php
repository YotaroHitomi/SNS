@extends('layouts.logout')

@section('content')
<!-- 適切なURLを入力してください -->
<div class="text-content">

{!! Form::open(['url' => '/login']) !!}

<p>AtlasSNSへようこそ</p>

<div class="mail">

{{ Form::label('e-mail' ) }}

<br>
{{ Form::text('mail',null,['class' => 'input']) }}

</div>

<div class="password">
{{ Form::label('password') }}
<br>
{{ Form::password('password',['class' => 'input']) }}

</div>

<div class="login">

{{ Form::submit('ログイン') }}

</div>

<div class="register">
<p><a href="/register">新規ユーザーの方はこちら</a></p>
</div>

{!! Form::close() !!}

@endsection

</div>
