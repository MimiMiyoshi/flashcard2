<?php
// getで送信されたidを取得
$id = $_GET['id'];

require_once('funcs.php');

//1.  DB接続します
$pdo = db_conn();

//３．データ削除SQL作成
$stmt = $pdo->prepare("DELETE FROM flashcard WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery:" . $error[2]);
} else {
    //５．index.phpへリダイレクト
    header('Location: list.php');
    exit;
}

?>