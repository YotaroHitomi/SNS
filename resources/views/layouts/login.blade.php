<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title>Atlas</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />

    <style>
        .header_box {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
        }

        .menu-trigger {
            cursor: pointer;
            font-size: 24px;
            color: #333;
        }

        .accordion-menu {
            position: absolute;
            top: 60px;
            left:50px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            z-index: 999;
            width: 300px;
            display: none;
        }

        .accordion-menu ul {
            list-style: none;
            margin-left:0px;
            padding: 0;
        }

        .accordion-menu li {
            border-bottom: 1px solid #eee;
        }

        .accordion-menu li:last-child {
            border-bottom: none;
        }

        .accordion-menu a {
            display: block;
            padding: 30px 25px;
            color: #333;
            text-decoration: none;
            text-align:center;
        }

.accordion-menu a:hover {
    background-color: #000080; /* ブルー */
    color: #fff;               /* 白い文字 */
}
    .right {
        margin-top: 20px;
        margin-bottom: 20px;
        padding-top: 10px;
        padding-bottom: 10px;
        font-size: 16px;
    }
    </style>
</head>
<body>
<header>
    <div id="head">
        <h1><a href="{{ route('index') }}"><img src="{{ asset('images/atlas.png') }}" alt="Atlasロゴ"></a></h1>
        @auth
        <div class="header_box">
            <p class="right">{{ Auth::user()->username }}さん</p>
            <div class="menu-trigger"><i class="fas fa-bars"></i></div>
            <img src="{{ asset('images/icon1.png') }}" width="50" height="50">

            <div class="accordion-menu">
                <ul>
                    <li><a href="/top">HOME</a></li>
                    <li><a href="/profile">プロフィール編集</a></li>
                    <li><a href="/login">ログアウト</a></li>
                </ul>
            </div>
        </div>
        @endauth
    </div>
</header>

<div id="row">
    <div id="container">
        @yield('content')
    </div>

    @auth
    <div id="side-bar">
        <div id="confirm">
            <p>{{ Auth::user()->username }}さんの</p>
            <div style="margin-top:15px;">
                <p>フォロー数 &nbsp;&nbsp;&nbsp;{{ Auth::user()->followings()->count() }}名</p>
            </div>
            <p class="btn"><a href="/follow-list">フォローリスト</a></p>
            <div style="margin-top:15px;">
                <p>フォロワー数 {{ Auth::user()->followers()->count() }}名</p>
            </div>
            <p class="btn"><a href="/follower-list">フォロワーリスト</a></p>
        </div>
        <hr>
        <p class="btn" id="btn"><a href="/search">ユーザー検索</a></p>
    </div>
    @endauth
</div>

<footer></footer>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function () {
        $('.menu-trigger').on('click', function () {
            $('.accordion-menu').fadeToggle(200);
        });

        // メニュー以外をクリックしたら閉じる
        $(document).on('click', function (e) {
            if (!$(e.target).closest('.header_box').length) {
                $('.accordion-menu').fadeOut(200);
            }
        });
    });
</script>
</body>
</html>
