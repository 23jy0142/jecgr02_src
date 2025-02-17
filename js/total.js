// URLからデータを取得
const urlParams = new URLSearchParams(window.location.search);
const productName = urlParams.get('product_name');
const productPrice = urlParams.get('product_price');
const productQuantity = urlParams.get('product_quantity');

// 商品リストのテーブルを取得
const productList = document.getElementById('product_list');
const totalPriceElement = document.getElementById('total_price');

// URLから取得した商品情報を新しい行として追加
if (productName && productPrice && productQuantity) {
  const newRow = document.createElement('tr');
  newRow.innerHTML = `
    <td>${productName}</td>
    <td class="counter">${parseInt(productQuantity, 10)}</td>
    <td class="price">${parseInt(productPrice, 10)}</td>
  `;
  productList.appendChild(newRow);

  // 合計金額を再計算
  calculateTotal();
}

// 合計金額を計算する関数
function calculateTotal() {
  let total = 0;

  // 各商品の行をループ
  const rows = productList.getElementsByTagName('tr');

  // ヘッダー行をスキップして合計を計算
  for (let i = 1; i < rows.length; i++) {
    const row = rows[i];
    const quantityText = row.querySelector('.counter')?.textContent?.trim() || "0"; // 個数
    const priceText = row.querySelector('.price')?.textContent?.trim() || "0"; // 価格

    const quantity = parseInt(quantityText, 10); // 個数を整数に変換
    const price = parseInt(priceText, 10); // 価格を整数に変換

    if (!isNaN(quantity) && !isNaN(price)) {
      total += quantity * price; // 合計金額を加算
    }
  }

  // 合計金額を表示
  totalPriceElement.textContent = total;
  // 合計金額をローカルストレージに保存
  localStorage.setItem("total", total);
  // デバッグ用に合計金額をコンソール表示
  console.log("合計金額:", total);
}

// ページが読み込まれたら合計金額を計算
window.onload = function () {
  calculateTotal();
};
