@extends('layouts.login')

@section('content')

    <div class="container">
      <div class="ttle">
        <!-- <h2>Contact</h2>
        <p class="ja-title">お問い合わせ</p> -->
      </div>
      <form action="index.php" method="post">
        <div class="ct-block">
          <label class="contact-text" for="name">user name</label>
          <input id="name" class="form-name" type="text" name="yourname" placeholder="">
        </div>

        <div class="ct-block">
          <label class="contact-text" for="email">mail adress</label></label>
          <input id="email" class="form-mail" type="text" name="mail" placeholder="">
        </div>

        <div class="ct-block">
          <label class="contact-text" for="Password">Password</label></label>
          <input id="Password" class="Password" type="text" name="Password" placeholder="">
        </div>

          <div class="ct-block">
          <label class="contact-text" for="Password confirm">Password confirm</label></label>
          <input id="Password confirm" class="Password confirm" type="text" name="Password confirm" placeholder="">
         </div>
          <div class="ct-block">
            <label class="contact-text" for="bio">bio</label></label>
            <input id="bio" class="bio" type="text" name="bio" placeholder="">
         </div>
          <div class="ct-block">
            <label class="contact-text" for="icon image">icon image</label></label>
            <input id="icon image" class="icon-image" type="text" name="icon image" placeholder="">
          </div>
        </div>

@endsection
