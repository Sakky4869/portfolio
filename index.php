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
    <script src="./js/chart.min.js"></script>
    <!-- フォントデータ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>Sakai's Portfolio</title>
</head>

<body data-spy="scroll" data-target="#navigation-bar" data-offset="100">

    <!-- ------------------------------------------- -->
    <!-- ナビゲーションバー -->
    <!-- ------------------------------------------- -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark stick-top fixed-top" id="navigatoin-bar">

        <div class="container">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav ml-auto">

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#top">Top</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#productions">Productions</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#skills">Skills</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#about">About</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- ------------------------------------------- -->
    <!-- Top -->
    <!-- ------------------------------------------- -->

    <!-- ポートフォリオを開いたときに最初の出てくる部分 -->
    <!-- 自分の画像とか，あいさつ文とかでいいかな -->
    <!-- なんか遊び要素入れたい -->
    <div class="section" id="top">

        <div id="top-content">

            <div>
                <img id="top-image" src="./image/my_profile_black_and_white.png" alt="トップイメージ">
            </div>
            <div class="section-message" id="top-message-parent">

                <p>　　　　　　　　　　　　　　　　　</p>
                <p>はじめまして，酒井と申します</p>
                <p>見てくださり，ありがとうございます</p>
                <p>制作物や経験をまとめています</p>
                <p>最後まで見て頂ければ幸いです</p>
                <p>よろしくお願いいたします</p>
                <p>　　　　　　　　　　　　　　　　　</p>

            </div>
        </div>
    </div>

    <!-- ------------------------------------------- -->
    <!-- Productions -->
    <!-- ------------------------------------------- -->

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

        <div class="caption-message">

            <p>大学入学後からこれまでの作品をまとめています</p>
            <p>動画再生推奨ブラウザ：Chrome</p>

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
                                    <?php echo $production['description']; ?>
                                </p>

                            </div>

                            <!-- 詳細ページへのボタン -->
                            <div class="production-more-info">
                                <img class="more-info-image" src="./image/more_info.svg" alt="もっと詳しく！" data-toggle="modal" data-target="#more-info-modal">
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

            <script>
            </script>
        </div>
    </div>

    <!-- ------------------------------------------- -->
    <!-- 準備中モーダル -->
    <!-- ------------------------------------------- -->
    <div class="modal fade" id="more-info-modal" tabindex="-1" role="dialog" aria-labelledby="label-more-info" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="label-more-info"></h5>

                </div>

                <div class="modal-body">
                    <div style="height: 350px;" id="moreinfo-content">
                        <p style="font-size: xx-large;">ただいま準備中です</p>
                        <p>１週間ほどお待ちください</p>
                        <?php
                        for ($i = 0; $i < 3; $i++) {
                            echo '<img class="comming-soon" style="width: 100px;" src="./image/comming_soon.svg" alt="ただいま準備中です">';
                            echo '<img class="comming-soon-smile" style="width: 100px;" src="./image/comming_soon_smile.svg" alt="ただいま準備中です">';
                        }
                        ?>
                        <img style="width: 100px;" src="./image/comming_soon.svg" alt="ただいま準備中です">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- ------------------------------------------- -->
    <!-- Skills -->
    <!-- ------------------------------------------- -->
    <div class="section" id="skills">
        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>Skills</h1>
            <div class="caption-line caption-line-right"></div>

        </div>

        <div class="caption-message">

            <p>システム開発に限らず</p>
            <p>経験したことをまとめています</p>
            <p>現在準備中です</p>
            <p>1週間ほどお待ちください．</p>

        </div>

        <!-- スキルをカテゴリごとにレーダーチャートで表示する -->
        <!-- レーダーチャートはグリッドで一覧表示する -->
        <div class="container-fluid">

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-<?php echo $col_size ?> col-lg-<?php echo $col_size ?> col-xl-<?php echo $col_size ?> content-box">

                <div class="chart-box content">

                        <!-- チャートを作成するcanvasを用意 -->
                        <canvas id="myChart"></canvas>

                        <p>スキルを示すグラフ</p>

                        <script>
                            let ctx = document.getElementById('myChart').getContext('2d');
                            const NUMBER_CFG = {
                                count: 7,
                                min: 0,
                                max: 100
                            };

                            let myChart = new Chart(ctx, {
                                type: 'radar',
                                data: {
                                    labels: ['1', '2', '3', '4', '5', '6', '7'],
                                    datasets: [{
                                        labels: 'data set 1',
                                        data: [10, 20, 30, 40, 50, 60, 70],
                                        borderColor: 'rgba(255, 255, 255, 255)',
                                        backgroundColor: 'rgba(255, 0, 0, 5)'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Sample Chart'
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>

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

        <div class="caption-message">

            <p>このサイトおよび僕自身についてです</p>
            <p>現在準備中です</p>
            <p>1週間ほどお待ちください</p>

        </div>
    </div>

    <!-- ページのロード中に表示する画面 -->
    <div id="load-panel">
        <div id="load-text">
            コンテンツ読み込み中
        </div>
        <div class="progress">
            <div id="load-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
    </div>

    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</body>

</html>
