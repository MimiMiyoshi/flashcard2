<?php
require_once('funcs.php');

//1.  DB接続します
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM flashcard;");
$status = $stmt->execute();
$words = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Flashcard</title>
    <link rel="stylesheet" href="./css/notepad.css" /> 	
<link href="https://fonts.googleapis.com/css?family=Homemade+Apple rel="stylesheet>
  </head>
  <body>
    <!--Hey! This is the original version
of Simple CSS Waves-->

<div class="header">

  <!--Content before waves-->
  <div class="inner-header flex">

  <path fill="#FFFFFF" stroke="#000000" stroke-width="10" stroke-miterlimit="10" d="M57,283" />
  <g><path fill="#fff"
  d="M250.4,0.8C112.7,0.8,1,112.4,1,250.2c0,137.7,111.7,249.4,249.4,249.4c137.7,0,249.4-111.7,249.4-249.4
  C499.8,112.4,388.1,0.8,250.4,0.8z M383.8,326.3c-62,0-101.4-14.1-117.6-46.3c-17.1-34.1-2.3-75.4,13.2-104.1
  c-22.4,3-38.4,9.2-47.8,18.3c-11.2,10.9-13.6,26.7-16.3,45c-3.1,20.8-6.6,44.4-25.3,62.4c-19.8,19.1-51.6,26.9-100.2,24.6l1.8-39.7		c35.9,1.6,59.7-2.9,70.8-13.6c8.9-8.6,11.1-22.9,13.5-39.6c6.3-42,14.8-99.4,141.4-99.4h41L333,166c-12.6,16-45.4,68.2-31.2,96.2	c9.2,18.3,41.5,25.6,91.2,24.2l1.1,39.8C390.5,326.2,387.1,326.3,383.8,326.3z" />
  </g>
  </svg>
 
     <div class="notepad-container">
      <div class="title">
        <h1>Flash Card</h1>
      </div>
      <div class="notepad-card">
        <div class="front">
          <h2 id="word-display">Word</h2>
        </div>
        <div class="back">
          <p>
            <span id="type-display">Type</span><br />
            <span id="meaning-display">Meaning</span><br />
            <span id="phrase-display">Phrase</span>
          </p>
        </div>
      </div>

      <button id="flip-btn" class="flip-button">ページをめくる</button>
      <div id="navigation">
        <button id="prev-btn" class="arrow-btn">
          <span class="arrow left-arrow"></span> 前の単語
        </button>
        <button id="next-btn" class="arrow-btn">
          次の単語 <span class="arrow right-arrow"></span>
        </button>
      </div>
      <button id="reverse-btn" class="rvs-button">リバース</button>
      <!-- <button
        id="index-btn"
        class="index-button"
        onclick="location.href='index.php'"
      >
        登録画面に戻る
      </button> -->
      <div class="btn_03container">
<a href="index.php" class="btn_03">登録画面に戻る！</a>
<a href="list.php" class="btn_03">一覧を開く！</a>
</div>
       </div>
    </div>
  
    <!--Waves Container-->
    <div>
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
    <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
    </g>
    </svg>
    </div>
      
  
    <!--Waves end-->
    </div>
    <!--Header ends-->

    <script type="module">
    // PHPで取得したデータをJavaScriptに渡す
    const words = <?php echo json_encode($words, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

    let currentIndex = 0;
    let isReversed = false; // リバース状態のフラグ

      // HTML要素の取得
      const prevBtn = document.getElementById("prev-btn");
      const nextBtn = document.getElementById("next-btn");
      const flipBtn = document.getElementById("flip-btn");
      const card = document.querySelector(".notepad-card");
      const wordDisplay = document.getElementById("word-display");
      const typeDisplay = document.getElementById("type-display");
      const meaningDisplay = document.getElementById("meaning-display");
      const phraseDisplay = document.getElementById("phrase-display");
      const reverseBtn = document.getElementById("reverse-btn");

     
      // 単語を表示する関数
      function displayWord(index) {
           const wordData = words[index];
           //console.log("配列の中身を表示", wordData);
        // リバースフラグによって表示内容を切り替え
        if (isReversed) {
            //リバースの時はmeaningを前面に表示させる
          wordDisplay.textContent = wordData.meaning || "No meaning";
          meaningDisplay.textContent = wordData.word || "No word";
        } else {
            //リバースじゃない時はwordを前面に表示させる
          wordDisplay.textContent = wordData.word || "No word";
          meaningDisplay.textContent = wordData.meaning || "No meaning";
        }

        typeDisplay.textContent = wordData.type || "No type";
        phraseDisplay.textContent = wordData.phrase || "No phrase";
      }

      // リバースボタンの動作
      reverseBtn.addEventListener("click", () => {
        // リバース状態を切り替え
        isReversed = !isReversed;
        // 現在の単語を再表示
        displayWord(currentIndex);
      });

      //前の単語ボタンの動作
      prevBtn.addEventListener("click", () => {
        if (words.length === 0) return;
        currentIndex = (currentIndex - 1 + words.length) % words.length; //前に戻る
        displayWord(currentIndex);
      }),
        // 次の単語ボタンの動作
        nextBtn.addEventListener("click", () => {
          if (words.length === 0) return;
          currentIndex = (currentIndex + 1) % words.length; // 次に進む
          displayWord(currentIndex); // 単純に単語を切り替える
        });

      // ページめくりボタンの動作
      flipBtn.addEventListener("click", () => {
        // カードを回転
        card.classList.toggle("flipped");
      });
      //最初の表示
      if (words.length > 0) {
        displayWord(currentIndex);
      }
    </script>
  </body>
</html>
