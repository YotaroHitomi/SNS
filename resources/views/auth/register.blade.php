@extends('layouts.logout')

@section('content')

<style>
    .text-content {
        width: 100%;
        max-width: 400px;
        margin: 50px auto;
        color: #fff;
    }

    h2 {
        font-size: 26px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
    }

    .input-block {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .input {
        width: 100%;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 16px;
    }

    .invalid-feedback {
        color: #ffb3b3;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }

    .submit-button {
        text-align: center;
        margin-top: 20px;
    }

    .submit-button input[type="submit"] {
        background-color: red;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
    }

    .back-to-login {
        text-align: center;
        margin-top: 20px;
    }

    .back-to-login a {
        color: white;
        text-decoration: underline;
        font-size: 14px;
    }
</style>

<div class="text-content">
    {!! Form::open(['url' => '/register']) !!}

    <h2>新規ユーザー登録</h2>

    <div class="input-block">
        @if ($errors->has('username'))
            <span class="invalid-feedback" role="alert">{{ $errors->first('name') }}</span>
        @endif
        {{ Form::label('username', 'ユーザー名') }}
        {{ Form::text('username', null, ['class' => 'input']) }}
    </div>

    <div class="input-block">
        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">{{ $errors->first('email') }}</span>
        @endif
        {{ Form::label('email', 'メールアドレス') }}
        {{ Form::text('email', null, ['class' => 'input']) }}
    </div>

    <div class="input-block">
        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">{{ $errors->first('password') }}</span>
        @endif
        {{ Form::label('password', 'パスワード') }}
        {{ Form::password('password', ['class' => 'input']) }}
    </div>

    <div class="input-block">
        {{ Form::label('password_confirmation', 'パスワード確認') }}
        {{ Form::password('password_confirmation', ['class' => 'input']) }}
    </div>

    <div class="submit-button">
        {{ Form::submit('新規登録') }}
    </div>

    <div class="back-to-login">
        <p><a href="/login">ログイン画面へ戻る</a></p>
    </div>

    {!! Form::close() !!}
</div>

@endsection
