<?php
$id = $_GET['id'];

require_once('funcs.php');

//1.  DB接続します
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM flashcard WHERE id = :id;");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view ="";
if ($status === false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

} else {


  $result = $stmt->fetch();

  }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>詳細確認</title>
    <link rel="stylesheet" href="css/style2.css" />
  </head>

  <body>
    <div id="register-screen" class="screen">
      <div id="background"></div>
      <form method="post" action="update.php" >
      <div id="content">
        <h1>詳細確認</h1>

        <fieldset>
        <div>
          <label>単語:</label>
          <input
            type="text"
            name="word"
            value="<?= $result['word']?>"
          />
        </div>
        <div>
          <label>品詞:</label>
          <select name="type" id="type"> 
            <option value="" <?= $result['type'] === "" ? "selected" : "" ?>>選んでね</option>
            <option value="noun" <?= $result['type'] === "noun" ? "selected" : "" ?>>名詞</option>
            <option value="verb" <?= $result['type'] === "verb" ? "selected" : "" ?>>動詞</option>
            <option value="adverb" <?= $result['type'] === "adverb" ? "selected" : "" ?>>副詞</option>
            <option value="adjective" <?= $result['type'] === "adjective" ? "selected" : "" ?>>形容詞</option>
            <option value="preposition" <?= $result['type'] === "preposition" ? "selected" : "" ?>>前置詞</option>
            <option value="idiom" <?= $result['type'] === "idiom" ? "selected" : "" ?>>熟語</option>
            <option value="other" <?= $result['type'] === "other" ? "selected" : "" ?>>その他</option>
          </select>
        </div>
        <div>
          <label>意味:</label>
          <input
            type="text"
            name="meaning"
            value="<?= $result['meaning']?>"
          />
        </div>
        <div>
          <label>例文やメモ:</label>
          <textarea
  name="phrase"
  id="phrase"><?= htmlspecialchars($result['phrase'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div class="button-container">
          <button id="send" type="submit" class="send">修正する</button>
          </fieldset>
</form>
<!-- <div class="btn_03container">
<a href="flashcard.php" class="btn_03">単語帳を開く！</a>
<a href="list.php" class="btn_03">一覧を開く！</a>
</div> -->
        <!-- <div id="output"></div> -->
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- <script type="module" src="js/index.js"></script> -->
  </body>
</html>
