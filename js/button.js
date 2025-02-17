function btn_countup() {
    // レタスの価格（固定値）
    const itemPay = 260;

    // カウンター要素を取得
    const counterElm = document.getElementById("counter");
    let count = parseInt(counterElm.innerText); // 現在の個数を数値として取得

    // カウンターを1増やして表示を更新
    count++;
    counterElm.innerText = count;

    // 合計金額を更新
    updateTotal(itemPay, count);
}

function btn_countdown() {
    // レタスの価格（固定値）
    const itemPay = 260;

    // カウンター要素を取得
    const counterElm = document.getElementById("counter");
    let count = parseInt(counterElm.innerText); // 現在の個数を数値として取得

    // カウンターが0以上の場合のみ減らす
    if (count > 0) {
        count--;
        counterElm.innerText = count;

        // 合計金額を更新
        updateTotal(itemPay, count);
    }
}

// 合計金額を更新する関数
function updateTotal(itemPay, count) {
    // 合計金額を計算
    const total = itemPay * count;

    // 合計金額を表示する要素を取得し、更新
    const addPayTextElm = document.getElementById("addpay_text");
    addPayTextElm.innerText = total; // 合計金額を表示
}