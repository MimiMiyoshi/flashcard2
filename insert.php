<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// funcs.php を読み込む
require_once('funcs.php');

//1. POSTデータ取得
$word = $_POST['word'];
$type = $_POST['type'];
$meaning = $_POST['meaning'];
$phrase = $_POST['phrase'];

// var_dump($_POST);
// exit;

//2. DB接続します
  $pdo = db_conn();
  // try {
  //   //ID:'root', Password: xamppは 空白 ''
  //   $pdo = new PDO('mysql:dbname=gs_db_class;charset=utf8;host=localhost','root','');
  //   echo "接続成功！";
  // } catch (PDOException $e) {
  //   exit('DBConnectError:'.$e->getMessage());
  // }

//３．データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT
                            INTO
                        flashcard(id, word, type, meaning, phrase)
                        VALUES(NULL, :word, :type, :meaning, :phrase)"
                    );

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':word', $word, PDO::PARAM_STR);
$stmt->bindValue(':type', $type, PDO::PARAM_STR);
$stmt->bindValue(':meaning', $meaning, PDO::PARAM_STR);
$stmt->bindValue(':phrase', $phrase, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status === false) {
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('SQLエラー:' . print_r($error, true));
} else {
  // echo "データ挿入成功！";
  // 単語登録が成功したらフラグを設定
$_SESSION['registered'] = true;
// リダイレクト
header("Location: index.php?screen=register");
exit;
}
?>
