<?php
require_once('funcs.php');

//1.  DB接続します
$pdo = db_conn();

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT word, meaning FROM flashcard;");
$status = $stmt->execute();

//３．データ表示
$flashcards = [];
if ($status) {
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (isset($result["word"], $result["meaning"])) {
            $flashcards[$result["word"]] = $result["meaning"];
        } else {
            error_log("Invalid data format: " . json_encode($result));
        }
    }
} else {
    echo "データ取得に失敗しました。";
    exit;
}

// データが空の場合の対応
if (empty($flashcards)) {
    echo "表示するデータがありません。";
    exit;
}

// ランダムに5つ選択
if (count($flashcards) < 5) {
    $selectedFlashcards = array_keys($flashcards);
} else {
    $selectedFlashcards = array_rand($flashcards, 5);
}

// Shuffle the words and meanings separately
$words = $selectedFlashcards;
$meanings = array_map(function($word) use ($flashcards) {
    return $flashcards[$word];
}, $selectedFlashcards);
shuffle($words);
shuffle($meanings);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flashcard Game</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/hamburger.css">
    <style>
            body {
        overflow-y: auto; /* 縦スクロールバーを自動で表示 */
    }
        .main-container {
            display: flex; /* WordsとMeaningsを左右に並べる */
            justify-content: center; /* 中央揃え */
            margin-top: 20px;
        }
        .container { 
            display: flex; 
            flex-direction: column;
            align-items: flex-start; 
            margin: 0 40px; 
        }

        .flashcard { 
            margin: 10px 0; 
            padding: 10px; 
            border: 1px solid #000; 
            border-radius: 8px; 
            cursor: pointer; 
            display: block;
            transition: border-color 0.3s;
            text-align: center;
            background-color: whitesmoke;
            height: 25px; /* 高さを固定 */
            size: 16px; /* テキストサイズ */
        }
            
        .flashcard:hover {
            border-color: #39ff14; /* 蛍光緑 */
        }

        .selected {
            border-color: #39ff14; /* 蛍光緑 */
        }

        .matched {
            background-color: #ccc; /* グレイアウト */
            color: #666; /* テキストも少し薄く */
            cursor: not-allowed; /* 選択不可のカーソル */
        }
        .restart-button {
    background-color: #ffcccb; /* 薄いピンク */
    border: none;
    border-radius: 12px; /* 角を丸くする */
    padding: 5px 10px;
    margin-top: 25px; /* 上との間にスペースを開ける */
    font-size: 14px;
    cursor: pointer;
}

.restart-button:hover {
    background-color: #ffb6c1; /* ホバー時の色 */
}
    </style>
    <script>
        let selectedWordElement = null;
        let selectedMeaningElement = null;

        function selectWord(element, word) {
            // 選択済みのカードがあれば選択を解除
            if (element.classList.contains('matched')) 
                return;
            
            if (selectedWordElement) {
                selectedWordElement.classList.remove('selected');
            }
            selectedWordElement = element;
            selectedWordElement.classList.add('selected');

            checkMatch(word, null);
        }

        function selectMeaning(element, meaning) {
            if(element.classList.contains('matched')) 
                return;
            if (selectedMeaningElement) {
                selectedMeaningElement.classList.remove('selected');
            }
            // 新しい選択を設定
            selectedMeaningElement = element;
            selectedMeaningElement.classList.add('selected');
            checkMatch(null, meaning);
        }

        function checkMatch(word, meaning) {
            if (selectedWordElement && selectedMeaningElement) {
                const flashcards = <?php echo json_encode($flashcards); ?>;
                const selectedWord = selectedWordElement.textContent.trim();
                const selectedMeaning = selectedMeaningElement.textContent.trim();

                if (flashcards[selectedWord] === selectedMeaning) {
                    // マッチした場合
                    selectedWordElement.classList.add('matched');
                    selectedMeaningElement.classList.add('matched');
                    selectedWordElement.classList.remove('selected');
                    selectedMeaningElement.classList.remove('selected');
                    selectedWordElement = null;
                    selectedMeaningElement = null;

                    // 全てマッチしたかどうか
                    checkAllMatched();

                } else {
                    alert("残念！ちょっと違うみたい。");
                    selectedWordElement.classList.remove('selected');
                    selectedMeaningElement.classList.remove('selected');
                    selectedWordElement = null;
                    selectedMeaningElement = null;
                }
            }
        }

        function checkAllMatched() {
            const allCards = document.querySelectorAll('.flashcard');
            const matchedCards = document.querySelectorAll('.matched');

            if (allCards.length === matchedCards.length) {
                setTimeout(() => {
                    alert("おめでとう！全てのカードがマッチしたよ⭐︎");
                }, 300);
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

    <h1 style="text-align: center; font-size: 35px;">テスト</h1>
    <p style="text-align: center; color:white">単語と意味をマッチさせてね☆</p>
    <div class="main-container">
        <div class="container">
            <h3 style="text-align: center; color:white">単語</h3>
            <?php foreach ($words as $word): ?>
                <div class="flashcard" onclick="selectWord(this, '<?php echo addslashes(htmlspecialchars($word, ENT_QUOTES)); ?>')"><?php echo htmlspecialchars($word, ENT_QUOTES); ?></div>
            <?php endforeach; ?>
        </div>
        <div class="container">
            <h3 style="text-align: center; color:white">意味</h3>
            <?php foreach ($meanings as $meaning): ?>
                <div class="flashcard" onclick="selectMeaning(this, '<?php echo addslashes(htmlspecialchars($meaning, ENT_QUOTES)); ?>')"><?php echo htmlspecialchars($meaning, ENT_QUOTES); ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <button class="restart-button" onclick="location.reload();">ゲームを最初からやり直す</button>
    </div>
    <div style="text-align: center; margin-top: 10px;">

    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="module" src="js/list.js"></script>
    <script src="js/hamburger.js"></script>
</body>
</html>