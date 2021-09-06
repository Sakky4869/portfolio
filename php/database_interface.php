<?php

// データベースに接続するための情報を読み取り
// $db_user   : データベースのユーザ名
// $db_passwd : データベースのパスワード
// $db_name   : データベースの名前
require_once('~/db_conf/db_conf.php');


function connect_to_db($user, $pass, $db){
    $link = mysqli_connect('localhost', $user, $pass, $db);
    return $link;
}


// 接続できたかチェック
// if(mysqli_connect_errno()){
//     die('データベースに接続できません：' . mysqli_connect_error() . "\n");
// }else{
//     echo 'データベースへの接続に成功しました';
// }

function get_production_datas($link)
{
    // クエリ
    $query = "select * from portfolio_productions";
    $statement = mysqli_prepare($link, $query);

    // 実行
    mysqli_stmt_execute($statement);

    // 変数をバインド
    mysqli_stmt_bind_result($statement, $id, $title, $description, $movie);

    // 結果を格納する配列を用意
    $results = array();

    // 結果取得
    while (mysqli_stmt_fetch($statement)) {
        $data = array();
        $data['title'] = $title;
        $data['description'] = $description;
        $data['movie'] = $movie;
        array_push($results, $data);
    }
    return $results;
}

