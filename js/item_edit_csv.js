document.addEventListener("DOMContentLoaded", () => {
  // ローカルストレージからデータを取得して表示する処理
  const storedData = JSON.parse(localStorage.getItem("itemDetails"));

  // データが存在する場合、表示する
  if (storedData) {
    document.getElementById("input_item_id").value = storedData.itemId;
    document.getElementById("input_item_name").value = storedData.itemName;
    document.getElementById("input_category").value = storedData.category;
    document.getElementById("input_item_stock").value = storedData.stock;

    // 入荷日を正しい形式に変換して設定
    const arrivalDate = new Date(storedData.arrivalDate);
    const formattedDate = arrivalDate.toISOString().split("T")[0];
    document.getElementById("input_arrival_date").value = formattedDate;

    // 必要であれば、税率設定をラジオボタンに反映
    if (storedData.tax === "10%") {
      document.querySelector(
        'input[name="tax"][value="tax_10"]'
      ).checked = true;
    } else if (storedData.tax === "8%") {
      document.querySelector('input[name="tax"][value="tax_8"]').checked = true;
    } else {
      document.querySelector(
        'input[name="tax"][value="tax_free"]'
      ).checked = true;
    }
  }
});

document.addEventListener("DOMContentLoaded", () => {
  const editButton = document.querySelector(
    '.button_row a[href="./uw203_2.html"]'
  );

  editButton.addEventListener("click", (event) => {
    event.preventDefault(); // デフォルトのリンク動作を防ぐ

    // 各<td>からデータを取得
    const itemData = {
      itemId: document.getElementById("input_item_id").value,
      itemName: document.getElementById("input_item_name").value,
      category: document.getElementById("input_category").value,
      tax: document.querySelector('input[name="tax"]:checked').value,
      stock: document.getElementById("input_item_stock").value,
      arrivalDate: document.getElementById("input_arrival_date").value,
    };

    // localStorage にデータを保存
    localStorage.setItem("itemDetails", JSON.stringify(itemData));

    // 次のページに遷移
    window.location.href = "./uw203_2.html";
  });
});
