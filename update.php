<?php
// funcs.php を読み込む
require_once('funcs.php');

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

//1. POSTデータ取得
$word = $_POST['word'];
$type = $_POST['type'];
$meaning = $_POST['meaning'];
$phrase = $_POST['phrase'];
$id     = $_POST['id']; //追加

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'UPDATE
        flashcard
    SET 
            word = :word, 
            type = :type, 
            meaning = :meaning, 
            phrase = :phrase
    WHERE id = :id;'   //WHEREを追加
);

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':word', $word, PDO::PARAM_STR);
$stmt->bindValue(':type', $type, PDO::PARAM_STR);
$stmt->bindValue(':meaning', $meaning, PDO::PARAM_STR); 
$stmt->bindValue(':phrase', $phrase, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //追加
$status = $stmt->execute(); //実行

//４．データ登録処理後
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: list.php');
    exit();
}