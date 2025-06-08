@extends('layouts.logout')

@section('content')

<style>
    .text-content {
        width: 100%;
        max-width: 400px;
        margin: 50px auto;
        color: #fff;
    }

    .text-content p.welcome {
        font-size: 28px; /* フォントサイズ大きめ */
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
    }

    .email, .password {
        margin-bottom: 20px;
        text-align: left;
    }

    .email label,
    .password label {
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    .input {
        width: 100%;
        padding: 15px;
        border-radius: 10px; /* 角丸 */
        border: 1px solid #ccc;
        box-sizing: border-box;
        font-size: 16px;
    }

    .login {
        text-align: center;
        margin-top: 30px;
    }

    .login input[type="submit"] {
        background-color: red;
        color: white;
        border: none;
        padding: 12px 40px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
    }

    .register {
        text-align: center;
        margin-top: 20px;
    }

    .register a {
        color: white;
        text-decoration: underline;
        font-size: 14px;
    }
</style>

<div class="text-content">

    {!! Form::open(['url' => '/login']) !!}
@csrf

    <p class="welcome">Atlas SNSへようこそ</p>

    <div class="email">
        {{ Form::label('email', 'メールアドレス') }}
        {{ Form::text('email', null, ['class' => 'input']) }}
    </div>

    <div class="password">
        {{ Form::label('password', 'パスワード') }}
        {{ Form::password('password', ['class' => 'input']) }}
    </div>

    <div class="login">
        {{ Form::submit('ログイン') }}
    </div>

    <div class="register">
        <p><a href="/register">新規ユーザーの方はこちら</a></p>
    </div>

    {!! Form::close() !!}
</div>

@endsection
