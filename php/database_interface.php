<?php

// データベースに接続するための情報を読み取り
// $db_user   : データベースのユーザ名
// $db_passwd : データベースのパスワード
// $db_name   : データベースの名前
require_once('../../db_conf/db_conf.php');

/**
 * データベースへの接続
 *
 * @param string $user データベースのユーザ名
 * @param string $pass データベースのパスワード
 * @param string $db データベース名
 * @return mysqli 接続オブジェクト
 */
function connect_to_db($user, $pass, $db)
{
    // $link = mysqli_connect('localhost', $user, $pass, $db);
    $mysqli = new mysqli('localhost', $user, $pass, $db);
    if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
    } else {
        $mysqli->set_charset('utf8');
        // echo 'db connect success' . "\n";
    }
    // return $link;
    return $mysqli;
}


/**
 * 制作物の全データを取得
 *
 * @param mysqli $link データベースへの接続オブジェクト
 * @return array 制作物データ一覧の配列
 */
function get_production_datas($link)
{
    // クエリ
    $query = "select * from portfolio_productions";

    // 実行
    $result = $link->query($query);

    // 出力用配列準備
    $return_array = array();

    // 全データ出力
    while ($row = $result->fetch_assoc()) {
        $data = array();
        $data['title'] = $row['title'];
        $data['description'] = $row['description'];
        $data['movie'] = $row['movie'];
        $data['detail'] = $row['production_details'];
        array_push($return_array, $data);
    }

    // 接続閉じる
    $link->close();

    return $return_array;
}



/**
 * 制作物の全データを取得
 *
 * @param mysqli $link データベースへの接続オブジェクト
 * @return array 制作物データ一覧の配列
 */
function get_production_title_datas($link)
{
    // クエリ
    $query = "select title from portfolio_productions";

    // 実行
    $result = $link->query($query);

    // 出力用配列準備
    $return_array = array();

    // 全データ出力
    while ($row = $result->fetch_assoc()) {
        // $data = array();
        // $data['title'] = $row['title'];
        // $data['description'] = $row['description'];
        // $data['movie'] = $row['movie'];
        array_push($return_array, $row['title']);
    }

    // 接続閉じる
    $link->close();

    return $return_array;
}





/**
 * スキルデータ一覧を取得
 *
 * @param mysqli $link データベースへの接続オブジェクト
 * @return array スキルデータ一覧の配列
 */
function get_skill_datas($link)
{
    // クエリ
    $query = "select * from portfolio_skills";

    $result = $link->query($query);

    $return_array = array();

    while ($row = $result->fetch_assoc()) {
        if (isset($return_array[$row['kind']]) == false) {
            $return_array[$row['kind']] = [];
        }
        $return_array[$row['kind']][$row['language']] = $row['value'];
    }

    $link->close();

    return $return_array;
}

/**
 * スキルデータをJSON形式で取得する
 *
 * @param mysqli $link データベースへの接続オブジェクト
 * @return string スキルデータのJSON文字列
 */
function get_skill_datas_json($link)
{
    $result = get_skill_datas($link);
    return json_encode($result, JSON_UNESCAPED_UNICODE);
}

/**
 * スキルデータの言語一覧を取得する
 *
 * @param mysqli $link
 * @return array
 */
function get_language_datas($link)
{
    // クエリ
    $query = "select language from portfolio_skills";

    $result = $link->query($query);

    $return_array = array();

    while ($row = $result->fetch_assoc()) {
        array_push($return_array, $row['language']);
    }

    $link->close();
    return $return_array;
}

/**
 * スキルの種別のデータを取得
 *
 * @param mysqli $link
 * @return array
 */
function get_kind_datas($link)
{
    // クエリ
    $query = "select kind from portfolio_skills";

    $result = $link->query($query);

    $return_array = array();

    while ($row = $result->fetch_assoc()) {
        if(in_array($row['kind'], $return_array) == false){
            array_push($return_array, $row['kind']);
        }
    }

    $link->close();

    return $return_array;
}

/**
 * 制作物情報が新しいものかをチェック
 *
 * @param mysqli $link
 * @param string $title
 * @return bool
 */
function check_is_new_production($link, $title){
    // クエリ
    $query = "select title from portfolio_productions where title=?;";

    if ($statement = $link->prepare($query)) {
        // パラメータをバインド
        $statement->bind_param("s", $title);

        // 実行
        $statement->execute();

        // 結果をバインド
        $statement->store_result();
        // すでにタイトルが登録されていれば，falseを返す
        if ($statement->num_rows == 1) {
            return false;
        }

        $link->close();
        return true;
    }
}

/**
 * 新しい制作物情報の登録
 *
 * @param mysqli $link
 * @param string $title
 * @param string $description
 * @param string $movie
 * @return void
 */
function insert_production_data($link, $title, $description, $movie, $details){
    $query = "insert into portfolio_productions values(null, ?, ?, ?, ?);";

    // $query = "select * from portfolio_cms_authentication where user_name=? and passwd=?";
    if ($statement = $link->prepare($query)) {
        // パラメータをバインド
        $statement->bind_param("ssss", $title, $description, $movie, $details);

        // 実行
        $statement->execute();

        // 結果をバインド
        $statement->store_result();

        // echo $statement->get_result();
        // echo "result : " . $statement->num_rows . "\n";

        $link->close();
    }else{
        echo $link->error . "\n";
    }
    
}

function update_production_data($link, $title, $description, $movie, $production_details){
    // クエリ
    $query = "update portfolio_productions set ";

    $is_first_variable = true;
    
    $bind_mark = '';
    $bind_param_array = array();
    
    if($description != ''){
        $query .= 'description=?';
        $is_first_variable = false;
        $bind_mark .= 's';
        array_push($bind_param_array, $description);
    }
    
    if($movie != ''){
        
        $query .=  ($is_first_variable) ? ' ' : ', ' . 'movie=?';
        $is_first_variable = false;
        $bind_mark .= 's';
        array_push($bind_param_array, $movie);
    }

    if($production_details != ''){
        $query .=  ($is_first_variable) ? ' ' : ', ' . 'production_details=?';
        $bind_mark .= 's';
        array_push($bind_param_array, $production_details);
    }

    $query .= ' where title=?;';

    // echo $query . "\n";

    $bind_mark .= 's';
    array_push($bind_param_array, $title);

    // var_dump($bind_mark);
    // var_dump($bind_param_array);

 
    if ($statement = $link->prepare($query)) {

        // echo $statement->error . "\n";

        // echo 'prepare' . "\n";

        // パラメータをバインド
        $statement->bind_param($bind_mark, ...$bind_param_array);

        // echo 'bind' . "\n";

        // 実行
        $statement->execute();

        // echo 'execute' . "\n";

        // 結果をバインド
        $statement->store_result();

        // echo $statement->get_result();
        // すでにタイトルが登録されていれば，falseを返す

        $link->close();
        return true;
    }

    return false;
}


/**
 * CMSサービスへの認証
 *
 * @param mysqli $link データベースへの接続オブジェクト
 * @param string $user_name CMSサービスのユーザ名
 * @param string $passwd CMSサービスのパスワード
 * @return bool ログインできたらtrue できなければfalse
 */
function authenticate($link, $user_name, $passwd)
{

    $query = "select * from portfolio_cms_authentication where user_name=? and passwd=?";
    if ($statement = $link->prepare($query)) {
        // パラメータをバインド
        $statement->bind_param("ss", $user_name, $passwd);

        // 実行
        $statement->execute();

        // 結果をバインド
        $statement->store_result();
        // echo "result : " . $statement->num_rows . "\n";
        if ($statement->num_rows == 1) {
            return true;
        }

        $link->close();
        return false;
    }
}


// ---- ここから先は実行テスト ----

// var_dump(insert_production_data(connect_to_db('sakai', 'tyoshino', 'sakai'), 'Test', 'descripton', 'movie', 'detials'));

// $ret = authenticate(connect_to_db($db_user, $db_passwd, $db_name), 'sakai', 'jcjPortfolioCMS4869');
// if($ret == true){
//     echo "true\n";
// }else{
//     echo "false\n";
// }
// $productions = get_production_datas(connect_to_db($db_user, $db_passwd, $db_name));
// echo var_dump($productions);
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
