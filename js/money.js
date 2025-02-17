document.addEventListener("DOMContentLoaded", function () {
    // ローカルストレージから合計金額を取得
    const totalAmount = parseInt(localStorage.getItem("total"), 10) || 0;

    // 初期表示
    document.querySelector(".allpay_price").textContent = totalAmount;

    const inputAmount = document.getElementById("input_amount");
    const shortfallElement = document.getElementById("shortfall_amount");
    const changeElement = document.querySelector(".changepay_price");

    // 入力変更時の計算
    inputAmount.addEventListener("input", function () {
        const input = parseInt(inputAmount.value, 10) || 0;

        // 不足金額とおつりを計算
        const shortfall = totalAmount > input ? totalAmount - input : 0;
        const change = input > totalAmount ? input - totalAmount : 0;

        // おつり金額をローカルストレージに保存
        localStorage.setItem("change",change);
        // 表示を更新
        shortfallElement.textContent = shortfall;
        changeElement.textContent = change;
    });
});
