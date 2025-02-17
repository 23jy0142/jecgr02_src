document.addEventListener("DOMContentLoaded", function () {
    // ローカルストレージからおつり金額を取得
    const changeAmount = parseInt(localStorage.getItem("change"), 10) || 0;

    // 初期表示
    document.querySelector(".change_text").textContent = changeAmount;

});