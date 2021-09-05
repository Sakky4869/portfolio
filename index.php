<?php
ini_set('display_errors', 1);
require_once './php/database_interface.php';
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.3.1.slim.min.js"></script>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <script src="./js/main.js"></script>
    <link rel="stylesheet" href="./css/main.css">
    <!-- フォントデータ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>Sakai's Portfolio</title>
</head>

<body data-spy="scroll" data-target="#navigation-bar" data-offset="100">
    <!-- ナビゲーションバー -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark stick-top fixed-top" id="navigatoin-bar">

        <div class="container">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <!-- <ul class="navbar-nav"></ul> -->

                <ul class="navbar-nav ml-auto">

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#top">Top</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#productions">Productions</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#about">About</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>



    <!-- ポートフォリオを開いたときに最初の出てくる部分 -->
    <!-- 自分の画像とか，あいさつ文とかでいいかな -->
    <!-- なんか遊び要素入れたい -->
    <div class="section" id="top">

        <div id="top-content">

            <div>
                <img id="top-image" src="./image/my_profile_black_and_white.png" alt="トップイメージ">
            </div>
            <div id="top-message-parent">

                <p>はじめまして，酒井と申します</p>
                <p>見てくださり，ありがとうございます</p>
                <p>これまでの制作物や経験したことをまとめていますので</p>
                <p>最後まで見て頂ければ幸いです</p>
                <p>よろしくお願いいたします</p>

            </div>
        </div>
        <!-- <div>
            <img id="next-navigator" src="./image/next_navigator.svg" alt="">
        </div> -->
    </div>



    <!-- これまで作った作品をまとめて紹介 -->
    <!-- グリッドで表示 -->
    <!-- PC：横に３つ -->
    <!-- スマホ：横に１つ -->
    <div class="section" id="productions">

        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>Productions</h1>
            <div class="caption-line caption-line-right"></div>

        </div>

        <div class="container-fluid">

            <div class="row">

                <?php

                // Bootstrapのグリッドのサイズを変数として保存
                $col_size = 4;

                // データベースからデータを取得
                $productions = get_production_datas(connect_to_db($db_user, $db_passwd, $db_name));

                for ($i = 0; $i < count($productions); $i++) {

                    $production = $productions[$i];
                ?>
                    <!-- グリッドのセル -->
                    <div class="col-xs-12 col-sm-12 col-md-<?php echo $col_size ?> col-lg-<?php echo $col_size ?> col-xl-<?php echo $col_size ?> content-box">

                        <!-- コンテンツ本体 -->
                        <div class="content">

                            <!-- タイトル -->
                            <div class="production-title">
                                <?php
                                echo $production['title'];
                                ?>
                            </div>

                            <!-- 動画 -->
                            <div class="production-movie">

                                <?php
                                if (isset($production['movie'])) {
                                    echo $production['movie'];
                                } else {
                                    echo 'Comming Soon !!';
                                }
                                ?>
                            </div>

                            <!-- 概要説明 -->
                            <div class="production-description">

                                <p>
                                    <?php
                                    echo $production['description'];
                                    ?>
                                </p>

                            </div>

                            <!-- 詳細ページへのボタン -->
                            <div class="production-more-info">
                                <img class="more-info-image" src="./image/more_info.svg" alt="もっと詳しく！">
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>



    <!-- このポートフォリオサイトについて -->
    <!-- 使用した言語とかフレームワークとか書いてみる？ -->
    <div class="section" id="about">

        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>About</h1>
            <div class="caption-line caption-line-right"></div>

        </div>
    </div>

    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>

</html>