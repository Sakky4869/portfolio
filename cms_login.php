<?php
ini_set('display_errors', 0);
require_once './php/database_interface.php';

session_start();

if (isset($_POST['user_name'])) {
    // データベースに接続
    $link = connect_to_db($db_user, $db_passwd, $db_name);

    // ログイン情報参照
    $result = authenticate($link, $_POST['user_name'], $_POST['passwd']);
    if ($result == true) {
        $_SESSION['user_name'] = $_POST['user_name'];
        setcookie('user_name', $_POST['user_name'], time() + 60 * 60 * 24 * 7, '/', 'grapefruit.sys.wakayama-u.ac.jp', true, true);
        header('Location: ./cms.php');
        exit();
    } else {
        echo "<script>";

        echo "alert('ユーザ名またはパスワードが違います')";

        echo "</script>";
    }
}

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
    <link rel="stylesheet" href="./css/cms_login.css">
    <!-- フォントデータ -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
    <title>Portfolio CMS</title>
</head>

<body data-target="#navigation-bar" data-offset="100">

    <!-- ------------------------------------------- -->
    <!-- ナビゲーションバー -->
    <!-- ------------------------------------------- -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark stick-top fixed-top" id="navigatoin-bar">

        <div class="container">
            <a class="navbar-brand" href="#">CMS Login</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">

                <ul class="navbar-nav ml-auto">

                    <li class="navbar-item ml-auto">
                        <a class="nav-link" href="#top"></a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- ------------------------------------------- -->
    <!-- 作品タイトル -->
    <!-- ------------------------------------------- -->


    <div class="section" id="production-title">


        <div class="container-fluid">
            <form action="./cms_login.php" method="post">
                <div class="form-group">
                    <label for="user_name">ユーザ名</label>
                    <input type="text" class="form-control" name="user_name" id="user-name-text">
                </div>
                <div class="form-group">
                    <label for="passwd">パスワード</label>
                    <input type="text" class="form-control" name="passwd" id="passwd-text">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-dark">
                </div>
            </form>
        </div>
    </div>


    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>

</body>

</html>