<?php
ini_set('display_errors', 1);
require_once './php/database_interface.php';

/**
 * このファイルは，ポートフォリオのCMSページ
 * 
 * ・制作物データの構造
 *  ・ID：auto increment
 *  ・title：制作物のタイトル
 *  ・description：制作物の説明
 *  ・movie：動画のURL（Google Driveのiframe）
 * 
 * ・スキルデータの構造
 *  ・ID：auto increment
 *  ・language：言語名
 *  ・value：スキルレベル（１～５）
 *  ・kind：スキルの使用用途
 * 
 * 
 * やること
 * ・管理者ログインチェック
 * ・制作物情報がPOSTされたとき
 *  ・新規の制作物ならば，新たに登録
 *  ・既存の制作物ならば，情報を更新
 */

// ログイン情報があるかチェック
if (isset($_SESSION['user_name']) == false && isset($_COOKIE['user_name']) == false) {

    // ログインしていなければ，ログインページへ
    header('Location: ./cms_login.php');
    exit();
}


$msg = '';

// 追加情報をデータベースに格納する
if (isset($_POST['section'])) {

    // 制作物情報だった場合
    if ($_POST['section'] == 'productions') {

        // タイトル取得
        $production_title = $_POST['production-title'];
        
        // 概要説明取得
        $production_description = '';
        if(isset($_POST['production-description'])){
            $production_description = $_POST['production-description'];
        }

        // 動画のURL取得
        $production_movie = '';
        if(isset($_POST['production-movie'])){
            $production_movie = $_POST['production-movie'];
        }

        // 動画の詳細情報取得
        $production_details = '';
        if(isset($_POST['production-details'])){
            $production_details = $_POST['production-details'];
        }

        // 新規制作物の場合は，insert
        if($production_title == '新規'){
            $production_title = $_POST['production-title-text'];
            $msg = insert_production_data(connect_to_db($db_user, $db_passwd, $db_name), $production_title, $production_description, $production_movie, $production_details);
        }
        // 情報更新の場合は，update
        else{
            // 何かしら情報が入力されている場合のみ更新 
            if($production_description != '' || $production_movie != '' || $production_details != ''){
                $msg = update_production_data(connect_to_db($db_user, $db_passwd, $db_name), $production_title, $production_description, $production_movie, $production_details);
            }
        }
        // 新規の制作物であれば，新たに登録する
        // if(check_is_new_production(connect_to_db($db_user, $db_passwd, $db_name), $production_title)){
        //     $msg = insert_production_data(connect_to_db($db_user, $db_passwd, $db_name), $production_title, $production_description, $production_movie);
        //     var_dump($msg);
        // }

        // $msg = $production_title . ' ' . $production_description . ' ' . $production_movie . 'insert production data';
    }else if($_POST['section'] == 'skills'){
        
    }
}else{
    // $msg = 'post data none';
}

// ページをリロードしたときにフォームを再送信しないようにする
// やっていることとしては，フォームデータを読み込んだあとに，ページをここにリダイレクトする
// すると，POSTデータが消えるらしい
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    header('Location: ./cms.php');
    exit;
}

$production_datas = get_production_datas(connect_to_db($db_user, $db_passwd, $db_name));
$production_datas_string = json_encode($production_datas, JSON_UNESCAPED_UNICODE);

$production_title_datas = get_production_title_datas((connect_to_db($db_user, $db_passwd, $db_name)));
// var_dump($production_title_datas);

$production_title_datas_string = implode(',', $production_title_datas);

// echo $production_datas_string . '<br>';

$language_datas_array = get_language_datas(connect_to_db($db_user, $db_passwd, $db_name));
$language_datas_string = implode(",", $language_datas_array);

// echo $language_datas_string . '<br>';

$kind_datas_array = get_kind_datas(connect_to_db($db_user, $db_passwd, $db_name));
$kind_datas_string = implode(",", $kind_datas_array);

// echo $kind_datas_string;

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
    <link rel="stylesheet" href="./css/main.css">
    <link rel="stylesheet" href="./css/cms.css">
    <script src="./js/marked.min.js"></script>
    <script src="./js/cms.js"></script>
    <!-- フォントデータ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>Portfolio CMS</title>
    <script>

        // 制作物データを取得
        let productionData = <?php echo $production_datas_string; ?>;

        // console.log(productionData);
        // 

        // 制作物のタイトルデータのみを取得
        let productionTitleData = '<?php echo $production_title_datas_string; ?>';
        // console.log(productionTitleData);
        // console.log(productionData);
        // console.log(productionData[0]['title']);

        // スキルの言語データを文字列として取得
        let languageData = <?php echo'"' . $language_datas_string . '"'; ?>;
        // console.log(languageData);
    
        // スキルの種類データを文字列として取得
        let kindData = <?php echo '"' . $kind_datas_string . '"'; ?>;

        // console.log('<?php echo $msg; ?>');
    </script>
</head>

<body data-target="#navigation-bar" data-offset="100">

    <!-- ------------------------------------------- -->
    <!-- ナビゲーションバー -->
    <!-- ------------------------------------------- -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark stick-top fixed-top" id="navigatoin-bar">

        <div class="container">
            <a class="navbar-brand" href="#">CMS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav ml-auto">

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#preview">Preview</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#productions">Productions</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#skills">Skills</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#experiences">Experiences</a>
                    </li>

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#about">About</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>


    <!-- ------------------------------------------- -->
    <!-- Preview -->
    <!-- ------------------------------------------- -->


    <div class="section" id="preview">

        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>Preview</h1>
            <div class="caption-line caption-line-right"></div>

        </div>


        <div class="container-fluid">
            <div class="preview-iframe-parent">
                <!-- <iframe src="./index.php" frameborder="0" width="100%" height="500px"></iframe> -->
            </div>
        </div>
    </div>


    <!-- ------------------------------------------- -->
    <!-- Productions -->
    <!-- ------------------------------------------- -->


    <div class="section" id="productions">

        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>Productions</h1>
            <div class="caption-line caption-line-right"></div>

        </div>


        <div class="container-fluid">

            <div class="content-box">

                <div class="content">

                    <form name="productionForm" action="./cms.php" method="post">
                        <!-- 追加対象のsectionのデータ -->
                        <input type="hidden" name="section" value="productions">
                        <div class="form-group">
                            <label for="production-title">制作物タイトル</label>
                            <select required class="custom-select" name="production-title" id="production-title-select"></select>
                            <input type="text" class="form-control" name="production-title-text" id="production-title-text">
                        </div>
                        <div class="form-group">
                            <label for="production-description">制作物の概要</label>
                            <textarea class="form-control" name="production-description" id="production-description-text"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="production-movie">制作物の動画のURL</label>
                            <input type="text" class="form-control" name="production-movie" id="production-movie-text">
                        </div>
                        <div class="form-group">
                            <label for="production-details-preview">制作物の詳細情報のプレビュー</label>
                            <div id="production-details-preview-div"></div>
                        </div>
                        <div class="form-group">
                            <label for="production-details">制作物の詳細情報</label>
                            <textarea class="form-control" name="production-details" id="production-details-text" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark">
                        </div>
                    </form>
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


        <div class="container-fluid">

            <div class="content-box">

                <div class="content">

                    <form name="skillForm" action="./cms.php" method="post">
                        <!-- 追加対象のsectionのデータ -->
                        <input type="hidden" name="section" value="skills">
                        <div class="form-group">
                            <label for="skill-name">言語名</label>
                            <select class="custom-select" name="skill-name" id="skill-name-select"></select>
                            <input type="text" class="form-control" name="skill-name-text" id="skill-name-text">
                        </div>
                        <div class="form-group">
                            <label for="skill-level">スキルレベル</label>
                            <select class="custom-select" name="skill-level" id="skill-level-select">
                                <option value="5">５：調べなくてもある程度作れる</option>
                                <option value="4">４：調べながらなんか作れる</option>
                                <option value="3">３：調べなくても基本的なコードがかける</option>
                                <option value="2">２：調べながら基本的なコードをかける</option>
                                <option value="1">１：授業などで軽く触った程度</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="skill-kind">種類</label>
                            <select class="custom-select" name="skill-kind" id="skill-kind-select"></select>
                            <input type="text" class="form-control" name="skill-kind" id="skill-kind-text">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-dark">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ------------------------------------------- -->
    <!-- Experiences -->
    <!-- ------------------------------------------- -->


    <div class="section" id="experiences">

        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>Experiences</h1>
            <div class="caption-line caption-line-right"></div>

        </div>


        <div class="container-fluid">

        </div>
    </div>


    <!-- ------------------------------------------- -->
    <!-- About -->
    <!-- ------------------------------------------- -->


    <div class="section" id="about">

        <!-- 見出し -->
        <div class="caption">

            <div class="caption-line caption-line-left"></div>
            <h1>About</h1>
            <div class="caption-line caption-line-right"></div>

        </div>


        <div class="container-fluid">

        </div>
    </div>


    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>

</body>

</html>