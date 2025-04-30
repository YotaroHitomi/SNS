@extends('layouts.login')

@section('content')

<div class="profile-container">
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
      <div class="form-row" style="display: flex; align-items: center;">
        <!-- プロフィール画像の表示 -->
                 <div>
          <img src="images/icon1.png" alt="Profile Icon" style="width: 60px; height: 60px; border-radius: 50%;">
        </div>
        <dt>username</dt>
        <dd><input type="text" name="username" value="{{ old('name', auth()->user()->username) }}"></dd>
</div>

      <div class="form-row">
        <dt>email address</dt>
        <dd><input type="text" name="email" value="{{ old('email', auth()->user()->email) }}"></dd>
      </div>

      <div class="form-row">
        <dt>password</dt>
        <dd><input type="password" name="newpassword"></dd>
      </div>

      <div class="form-row">
        <dt>confirm password</dt>
        <dd><input type="password" name="newpassword_confirmation"></dd>
      </div>

      <div class="form-row">
        <dt>bio</dt>
        <dd><input type="text" name="bio" value="{{ old('bio', auth()->user()->bio) }}"></dd>
      </div>

<div class="form-row">
  <dt>icon image</dt>
  <dd><input type="file" name="iconimage" style="height: 125px;"></dd>
</div>
    </dl>

<input type="submit" name="profileupdate" value="更新" class="btn-update" style="background-color: red; color: white; border: none; padding: 10px 20px; width: 100%; max-width: 200px; border-radius: 5px; cursor: pointer;">

  </form>
</div>

@endsection
