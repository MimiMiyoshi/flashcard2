<?php
require_once('funcs.php');

//1.  DB接続します
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM flashcard;");
$status = $stmt->execute();

//３．データ表示
$view ="";
if ($status === false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {
      // 表のヘッダー
      $view .= "<table class='listTable'>";
      $view .= "<tr>";
      $view .= "<th>ID</th>";
      $view .= "<th>単語</th>";
      $view .= "<th>品詞</th>";
      $view .= "<th>意味</th>";
      $view .= "<th>例文</th>";
      $view .= "<th>削除</th>";
      $view .= "</tr>";

  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
        // $view .= "<>";
        $view .= "<td><a href='detail.php?id=" . h($result['id']) . "'>" . h($result['id']) . "</a></td>";
        $view .= "<td>" . h($result['word']) . "</td>";
        $view .= "<td>" . h($result['type']) . "</td>";
        $view .= "<td>" . h($result['meaning']) . "</td>";
        $view .= "<td>" . h($result['phrase']) . "</td>";
        $view .= "<td><button class='delete-btn' onclick='deleteItem(" . $result['id'] . ")'>削除</button></td>";
        $view .= '</p>';
        $view .= "</tr>";
  }
  $view .= "</table>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/hamburger.css">

    <script>
       
        function deleteItem(id) {
            if (confirm('本当に削除しますか？')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
    
</head>
<body>
  
  
<div id="register-screen" class="screen">
<div id="background"></div>

    <!-- ハンバーガーメニュー -->
    <div class="hamburger" onclick="toggleMenu()">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>

    <!-- 背景のオーバーレイ -->
    <div class="overlay" onclick="toggleMenu()"></div>

    <!-- メニュー -->
    <div class="menu-container">
        <div class="menu-header">
            <h2> </h2>
            <button class="close-btn" onclick="toggleMenu()">×</button>
        </div>
        <div class="menu">
            <a href="index.php">登録画面</a>
            <a href="search.php">単語検索</a>
            <a href="list.php">一覧</a>
            <a href="flashcard.php">単語帳</a>
            <a href="jeu1.php">ゲーム⭐︎</a>
        </div>
    </div>


<div><h1>単語の一覧です！</h1></div>
<h4 style="color: white;">登録内容を変更するときは、IDをクリックしてね。</h4>
    <div class="list-container">
        <?= $view ?>
    </div>

    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="module" src="js/list.js"></script>
    <script src="js/hamburger.js"></script>
</body>
</html>