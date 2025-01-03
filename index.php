


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>単語帳</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
    <!-- ゲート画面 -->
    <div id="gate-screen" class="screen0">
      <h1 class="gate-title">Welcome to Vocabulary World!</h1>
      <div class="selection-container">
        <button id="register-button">単語を登録する！</button>
        <!-- <button id="search-button">単語を探す！</button> -->
      </div>
    </div>

    <!-- 登録フォーム画面 -->
    <div id="register-screen" class="screen" style="display: none">
      <div id="background"></div>
      <form method="post" action="insert.php" >
      <div id="content">
        <h1>単語を登録しましょ！</h1>
        <fieldset>
        <div>
          <label>単語:</label>
          <input
            type="text"
            name="word"
            placeholder="単語を入力してね"
            required
          />
        </div>
        <div>
          <label>品詞:</label>
          <select name="type" id="type" required>
            <option value="">選んでね</option>
            <option value="noun">名詞</option>
            <option value="verb">動詞</option>
            <option value="adverb">副詞</option>
            <option value="adjective">形容詞</option>
            <option value="preposition">前置詞</option>
            <option value="idiom">熟語</option>
            <option value="other">その他</option>
          </select>
        </div>
        <div>
          <label>意味:</label>
          <input
            type="text"
            name="meaning"
            placeholder="単語の意味を入力してね"
            required
          />
        </div>
        <div>
          <label>例文やメモ:</label>
          <textarea
            name="phrase"
            id="phrase"
            placeholder="例文やメモを入力してね"
          ></textarea>
        </div>
        <div class="button-container">
          <button id="send" type="submit" class="send">登録する</button>
          </fieldset>
</form>
<div class="btn_03container">
<a href="flashcard.php" class="btn_03">単語帳を開く！</a>
<a href="list.php" class="btn_03">一覧を開く！</a>
</div>
        <div id="output"></div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="module" src="js/index.js"></script>
  </body>
</html>
