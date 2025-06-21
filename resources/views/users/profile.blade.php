@extends('layouts.login')

@section('content')

<div class="profile-container">
  <!-- プロフィール画像の表示 -->
  <div class="profile-image">
    <img src="images/icon1.png" alt="Profile Icon" style="width: 50px; height: 50px; border-radius: 50%; margin-left:35px ; margin-bottom:-35px; ">
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
        <dt>ユーザ名</dt>
        <dd><input type="text" name="username" value="{{ old('name', auth()->user()->username) }}"></dd>
      </div>

<div class="form-row">
  <dt>メールアドレス</dt>
  <dd><input type="text" name="email" value="{{ old('email', auth()->user()->email) }}"></dd>
</div>

      <div class="form-row">
        <dt>パスワード</dt>
        <dd><input type="password" name="newpassword"></dd>
      </div>

      <div class="form-row">
        <dt>パスワード確認</dt>
        <dd><input type="password" name="newpassword_confirmation"></dd>
      </div>

<div class="form-row" style="margin-bottom: 20px;">
  <dt>自己紹介</dt>
  <dd><input type="text" name="bio" value="{{ old('bio', auth()->user()->bio) }}"></dd>
</div>

      <div class="form-row">
        <dt>アイコン画像</dt>
        <dd><input type="file" name="iconimage"></dd>
      </div>
    </dl>

    <style>
/* ddを中央揃えかつ幅いっぱいに */
.form-row dd {
  text-align: center;
  width: 100%;       /* 幅いっぱいに */
}

/* ファイル選択inputはinline-blockで幅は自動 */
input[type="file"] {
  display: inline-block;
  margin: 0 auto;
  background-color: white;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 10px 20px;
  font-size: 16px;
  cursor: pointer;
  color: transparent;
}

/* ボタン部分 */
input[type="file"]::file-selector-button {
  all: unset;
  display: inline-block;
  padding: 10px 25px;
  background-color: white;
  border-radius: 6px;
  color: #999999;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
  user-select: none;
}

input[type="file"]::file-selector-button:hover {
  background-color: #f0f0f0;
  border-color: #999;
}
</style>


    <input type="submit" name="profileupdate" value="更新" class="btn-update">
  </form>
</div>


@endsection
