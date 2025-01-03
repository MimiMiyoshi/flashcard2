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
