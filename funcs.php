<?php

//XSS対応
function h($stg) {
    return htmlspecialchars($stg, ENT_QUOTES);
}

//DB接続
function db_conn() {
  try {
    // 外部サーバーの設定

      //ID:'root', Password: xamppは 空白 ''
      $server_info = 'mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host;
      $pdo = new PDO($server_info, $db_user,$db_password);
      return $pdo; //PDOオブジェクトを返す
    } catch (PDOException $e) {
      // echo '接続エラー: ' . $e->getMessage(); // エラー内容を表示
      exit('DBConnectError:'.$e->getMessage());
    }
}

?>
