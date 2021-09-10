<?php

// データベースに接続するための情報を読み取り
// $db_user   : データベースのユーザ名
// $db_passwd : データベースのパスワード
// $db_name   : データベースの名前
require_once('../../db_conf/db_conf.php');


function connect_to_db($user, $pass, $db)
{
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

function get_skill_datas($link)
{
    // クエリ
    $query = "select * from portfolio_skills";
    $statement = mysqli_prepare($link, $query);

    // 実行
    mysqli_stmt_execute($statement);

    // 変数をバインド
    mysqli_stmt_bind_result($statement, $id, $language, $value, $kind);

    // 結果を格納する配列を用意
    $results = array();

    // 結果取得
    while (mysqli_stmt_fetch($statement)) {
        if (isset($results[$kind]) == false) {
            $results[$kind] = [];
        }
        $results[$kind][$language] = $value;
        // $data = [];
        // $data[$language] = $value;
        // echo 'language : ' . $language . ' value : ' . $value . "\n";
        // $data['language'] = $language;
        // $data['value'] = $value;
        // $data['k'] = $movie;
        // $results[$kind] = $data;
        // array_push($results[$kind], $data);

    }
    return $results;
    // $json = json_encode($results, JSON_UNESCAPED_UNICODE);
    // return json_decode()
    // return json_encode($results, JSON_UNESCAPED_UNICODE);
}

function get_skill_datas_json($link){
    $result = get_skill_datas($link);
    return json_encode($result, JSON_UNESCAPED_UNICODE);
}

// $skills = get_skill_datas(connect_to_db($db_user, $db_passwd, $db_name));
// echo $skills;
// var_dump($skills);
// ジャンルデータのみ抽出
// $kinds = array_keys($skills);
// for ($i = 0; $i < count($kinds); $i++) {
//     $languages = array_keys($skills[$kinds[$i]]);
//     for ($j = 0; $j < count($languages); $j++) {
//         echo 'kind : ' . $kinds[$i] . "\n";
//         echo '  language : ' . $languages[$j] . "\n";
//         echo '      value : ' . $skills[$kinds[$i]][$languages[$j]] . "\n";
//     }
// }
