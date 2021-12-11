<?php
ini_set('display_errors', 0);
require_once './php/database_interface.php';
$production_datas = get_production_datas(connect_to_db($db_user, $db_passwd, $db_name));
$production_datas_string = json_encode($production_datas, JSON_UNESCAPED_UNICODE);
$skill_datas = get_skill_datas(connect_to_db($db_user, $db_passwd, $db_name));
// var_dump($skill_datas);
$skill_datas_string = json_encode($skill_datas, JSON_UNESCAPED_UNICODE);
// スキルデータをグラフ描画用にJSON文字列として取得
$skills_json = get_skill_datas_json_for_chart(connect_to_db($db_user, $db_passwd, $db_name));
?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-192256010-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-192256010-1');
    </script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/jquery-3.3.1.slim.min.js"></script>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./css/main.css">
    <script src="./js/marked.min.js"></script>
    <script src="./js/chart.min.js"></script>
    <script src="./js/main.js"></script>
    <!-- フォントデータ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>Sakai's Portfolio</title>
    <script>
        let productionDatas = <?php echo $production_datas_string; ?>;
        let skillDatas = <?php echo $skill_datas_string; ?>;
        // JavaScriptで使うために，JavaScriptのJSONオブジェクトとして保持
        let skills_json_string = <?php echo "'" . $skills_json . "'"; ?>;
        // console.log(skills_json_string);
        let skills_json_object = JSON.parse(skills_json_string);
        // console.log(productionDatas);
    </script>
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

        <div class="modal-dialog modal-xl" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h3 class="modal-title" id="label-more-info"></h3>

                </div>

                <div class="modal-body">
                    <div id="moreinfo-content">
                        <!-- <p style="font-size: xx-large;">ただいま準備中です</p> -->
                        <!-- <p>１週間ほどお待ちください</p> -->
                        <?php
                        // for ($i = 0; $i < 1; $i++) {
                            // echo '<img class="comming-soon" style="width: 100px;" src="./image/comming_soon.svg" alt="ただいま準備中です">';
                            // echo '<img class="comming-soon-smile" style="width: 100px;" src="./image/comming_soon_smile.svg" alt="ただいま準備中です">';
                        // }
                        ?>
                        <!-- <img style="width: 100px;" src="./image/comming_soon.svg" alt="ただいま準備中です"> -->
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

            <p>システム開発経験をまとめています</p>
            <p>指標は下記です</p>
            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                <p>５：調べなくてもある程度作れる</p>
                <p>４：調べながらなんか作れる</p>
                <p>３：調べなくても基本的なコードがかける</p>
                <p>２：調べながら基本的なコードをかける</p>
                <p>１：授業などで軽く触った程度</p>
            </div>

            <!-- <p>現在準備中です</p> -->
            <!-- <p>1週間ほどお待ちください．</p> -->

        </div>

        <!-- スキルをカテゴリごとにレーダーチャートで表示する -->
        <!-- レーダーチャートはグリッドで一覧表示する -->
        <div class="container-fluid">

            <div class="row">

                <?php
                // スキルデータをオブジェクトとして取得
                $skills_object = get_skill_datas_for_chart(connect_to_db($db_user, $db_passwd, $db_name));
                // var_dump($skills_object);
                $kinds = array_keys($skills_object);
                // var_dump($kinds);

                // ジャンルごとのデータを取得
                for ($i = 0; $i < count($kinds); $i++) {
                    $languages = array_keys($skills_object[$kinds[$i]]);
                    // var_dump($languages);
                ?>

                    <div class="col-xs-12 col-sm-12 col-md-<?php echo $col_size ?> col-lg-<?php echo $col_size ?> col-xl-<?php echo $col_size ?> content-box">

                        <div class="chart-box content">
                            <div class="production-title"></div>

                            <!-- チャートを作成するcanvasを用意 -->
                            <!-- <canvas id="myChart"></canvas> -->
                            <!-- チャートを作成するcanvasを用意 -->
                            <canvas class="skill-chart" data-kind="<?php echo $kinds[$i]; ?>"></canvas>

                            <!-- 詳細ページへのボタン -->
                            <div class="skill-more-info">
                                <img class="more-info-image" src="./image/more_info.svg" alt="もっと詳しく！" data-toggle="modal" data-target="#more-info-modal">
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

        <div class="caption-message">

            <p>本ポートフォリオのシステム構成図を</p>
            <p>下記に掲載しました．</p>
            <p>サーバは研究室のApacheサーバを使い，</p>
            <p>データベースはMySQLを利用しています．</p>
            <p>CMSをHTML, CSS, JavaScript, PHPで自作し，</p>
            <p>情報を更新しやすいようにしました．</p>
            <p>本ページはHTMLをベースに，</p>
            <p>でコンテンツを生成しています．</p>
            <br>
            <p>フレームワーク・ライブラリについて</p>
            <p>CSS：Bootstrap 4（UI作成に利用）</p>
            <p>JavaScript：Marked.js（グラフ描画に利用）</p>


            <img class="description-image" src="./image/system_architecture.svg" alt="システム構成図">
        </div>
    </div>

    <!-- ページのロード中に表示する画面 -->
    <div id="load-panel">
        <div id="load-text">
                iframe読み込み中
        </div>
        <div class="progress">
            <div id="load-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            </div>
        </div>
    </div>

    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>

    <?php
    // スキルデータをグラフ描画用にJSON文字列として取得
    // $skills_json = get_skill_datas_json_for_chart(connect_to_db($db_user, $db_passwd, $db_name));
    ?>

    <script type="text/javascript">
        // JavaScriptで使うために，JavaScriptのJSONオブジェクトとして保持
        // let skills_json_string = <?php //echo "'" . $skills_json . "'"; ?>;
        // console.log(skills_json_string);
        // let skills_json_object = JSON.parse(skills_json_string);
        // console.log(skills_json_object);
        // createSkillCharts(skills_json_object);
    </script>

</body>

</html>
