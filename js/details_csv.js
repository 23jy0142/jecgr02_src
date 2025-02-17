document.addEventListener('DOMContentLoaded', () => {
  // ローカルストレージからデータを取得して表示する処理
  const storedData = JSON.parse(localStorage.getItem("itemDetails")) || [];

  // データが存在する場合、表示する
  if (storedData.length > 0) {
    const item = storedData[0];
    document.getElementById("input_item_id").textContent = item.商品ID;
    document.getElementById("input_item_name").textContent = item.商品名;
    document.getElementById("input_category").textContent = item.カテゴリ;
    document.getElementById("input_maker").textContent = item.メーカー;
    document.getElementById("input_tax").textContent = item.消費税設定 || '10%'; // このフィールドがある場合
    document.getElementById("sales_price").textContent = item.価格;
    document.getElementById("input_item_stock").textContent = item.在庫数;
    document.getElementById("input_arrival_date").textContent = item.賞味期限 || '-'; // 変更が必要な場合は調整
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const editButton = document.querySelector('.button_row a[href="./uw203_2.html"]');

  editButton.addEventListener('click', (event) => {
    event.preventDefault(); // デフォルトのリンク動作を防ぐ

    // 各<td>からデータを取得
    const itemData = {
      itemId: document.getElementById('input_item_id').textContent,
      itemName: document.getElementById('input_item_name').textContent,
      category: document.getElementById('input_category').textContent,
      maker: document.getElementById('input_maker').textContent,
      tax: document.getElementById('input_tax').textContent,
      price: document.getElementById('sales_price').textContent,
      stock: document.getElementById('input_item_stock').textContent,
      arrivalDate: document.getElementById('input_arrival_date').textContent
    };

    // localStorage にデータを保存
    localStorage.setItem('itemDetails', JSON.stringify(itemData));

    // 次のページに遷移
    window.location.href = './uw203_2.html';
  });
});
