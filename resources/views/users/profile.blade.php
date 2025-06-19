@extends('layouts.login')

@section('content')

<div class="profile-container">
  <!-- プロフィール画像の表示 -->
  <div class="profile-image">
    <img src="images/icon1.png" alt="Profile Icon" style="width: 50px; height: 50px; border-radius: 50%; margin-left:100px ; margin-bottom:-25px; ">
  </div>

  <form action="{{ url('/profile') }}" enctype="multipart/form-data" method="POST" class="profile-form">
    @csrf
    @method('PUT') <!-- プロフィールの更新にPUTメソッドを使用 -->

    <!-- バリデーションエラーメッセージの表示 -->
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <dl class="UserProfile">
      <div class="form-row">
        <dt>Username</dt>
        <dd><input type="text" name="username" value="{{ old('name', auth()->user()->username) }}"></dd>
      </div>

<div class="form-row">
  <dt>Email Address</dt>
  <dd><input type="text" name="email" value="{{ old('email', auth()->user()->email) }}"></dd>
</div>

      <div class="form-row">
        <dt>Password</dt>
        <dd><input type="password" name="newpassword"></dd>
      </div>

      <div class="form-row">
        <dt>Confirm Password</dt>
        <dd><input type="password" name="newpassword_confirmation"></dd>
      </div>

<div class="form-row" style="margin-bottom: 20px;">
  <dt>Bio</dt>
  <dd><input type="text" name="bio" value="{{ old('bio', auth()->user()->bio) }}"></dd>
</div>

      <div class="form-row">
        <dt>Profile Icon</dt>
        <dd><input type="file" name="iconimage"></dd>
      </div>
    </dl>

    <input type="submit" name="profileupdate" value="更新" class="btn-update">
  </form>
</div>

@endsection
