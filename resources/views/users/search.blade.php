@extends('layouts.login')

@section('content')
<div class="user-search"></div>

    <div id="search">
      <form action="list.php" method="post">
        <input type="text" name="search" value="" placeholder="ユーザー名で検索">
        <button id="sbtn" type="submit">
          <i class="fa fa-search"></i>
        </button>
      </form>

    </div>

@endsection
