document.addEventListener("DOMContentLoaded", () => {
  //遷移先の取得
  const gateScreen = document.getElementById("gate-screen");
  const registerScreen = document.getElementById("register-screen");

  // URLパラメータを取得
  const params = new URLSearchParams(window.location.search);
  const screen = params.get("screen");

  // クエリパラメータに基づいて画面を切り替え
  if (screen === "register") {
    // 登録フォーム画面を表示
    gateScreen.style.display = "none";
    registerScreen.style.display = "block";

    // URLからクエリパラメータを削除（オプション）
    history.replaceState(null, "", window.location.pathname);
  } else {
    // ゲート画面を表示
    gateScreen.style.display = "block";
    registerScreen.style.display = "none";
  }

  //ボタンの取得
  const registerBtn = document.getElementById("register-button");
  //const searchBtn = document.getElementById("search-button");

  //register buttonのクリックイベント
  if (registerBtn) {
    registerBtn.addEventListener("click", () => {
      gateScreen.style.display = "none"; //ゲート画面を非表示
      registerScreen.style.display = "block"; //登録画面を表示
    });

    // searchBtn.addEventListener("click", () => {
    //   location.href = "search.php";
    // });
  }
});

// 品詞の英語名から日本語名へのマッピング
const typeMapping = {
  noun: "名詞",
  verb: "動詞",
  adverb: "副詞",
  adjective: "形容詞",
  preposition: "前置詞",
  idiom: "熟語",
  other: "その他",
};
// ページ読み込み後にスクリプトを実行
document.addEventListener("DOMContentLoaded", function () {
  console.log("ページが読み込まれました。createDotを開始します。");
  // ドットを生成して背景に追加する関数
  function createDot() {
    const background = document.getElementById("background");

    // 背景レイヤーが見つからない場合はエラーを表示
    if (!background) {
      console.error("背景レイヤー (#background) が見つかりません。");
      return;
    }

    const dot = document.createElement("div");
    dot.classList.add("dot");

    // ランダムなサイズと位置
    const size = Math.random() * 10 + 5; // 5px〜15pxのサイズ
    dot.style.width = `${size}px`;
    dot.style.height = `${size}px`;
    dot.style.left = `${Math.random() * 100}vw`; // 画面幅のランダムな位置
    dot.style.animationDuration = `${Math.random() * 5 + 5}s`; // 5〜10秒で落下

    // 背景に追加
    background.appendChild(dot);

    // 一定時間後にドットを削除
    setTimeout(() => {
      background.removeChild(dot);
    }, 10000); // アニメーション終了後に削除
  }

  // ドットを定期的に生成
  setInterval(createDot, 500); // 0.5秒ごとにドットを生成
});

//単語を登録する(Click)
// $("#send").on("click", function () {
//   console.log(phrase);
//   const tango = {
//     word: $("#word").val(),
//     type: $("#type").val(),
//     meaning: $("#meaning").val(),
//     phrase: $("#phrase").val(),
//   };

//   const newPostRef = push(dbRef);
//   set(newPostRef, tango);

//   //入力欄を空にする
//   $("#word").val("");
//   $("#type").val("");
//   $("#meaning").val("");
//   $("#phrase").val("");
// });

//データ登録(Enter)
// $("#phrase").on("keydown", function (e) {
//   console.log(e); //e変数の中身を確認！！
//   if (e.keyCode == 13) {
//     //EnterKey=13
//     const tango = {
//       word: $("#word").val(),
//       type: $("#type").val(),
//       meaning: $("#meaning").val(),
//       phrase: $("#phrase").val(),
//     };
//     const newPostRef = push(dbRef); //ユニークKEYを生成
//     set(newPostRef, tango); //"chat"にユニークKEYをつけてオブジェクトデータを登録
//   }
// });
