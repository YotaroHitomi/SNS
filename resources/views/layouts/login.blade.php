<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
</head>
<body>
    <header>
        <div id = "head">
            <h1><a href="/top"><img src="images/atlas.png"></a></h1>
            <div id="">
                <div id="">
                    <div class="header_box">
                        <p class="right">{{Auth::user()->username}}さん</p>
                        <div class="menu-trigger"></div>
                        <img src="images/icon1.png">
                    </div>
                    <div>
                        <ul class="acordion">
                            <li class="right"><a href="/top">ホーム</a></li>
                            <li class="right"><a href="/profile">プロフィール</a></li>
                            <li class="right"><a href="/login">ログアウト</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="row">
        <div id="container">
        @yield('content')
        </div >

        <div id="side-bar">
            <div id="confirm">
                <p>{{Auth::user()->username}}さんの</p>
                <div>
                    <p>フォロー数</p>
                    <p>〇〇名</p>
                </div>
                <p class="btn"><a href="/follow-list">フォローリスト</a></p>
                <div>
                    <p>フォロワー数</p>
                    <p>〇〇名</p>
                </div>
                <p class="btn"><a href="/follower-list">フォロワーリスト</a></p>
            </div>
            <p class="btn" id="btn"><a href="/search">ユーザー検索</a></p>
        </div>
    </div>
    <footer>
    </footer>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
