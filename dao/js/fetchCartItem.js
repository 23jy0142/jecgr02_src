$(document).ready(function () {
  function updateCartItems() {
    $.ajax({
      url: "../../dao/fetch_cart_items.php", // 非同期でデータ取得
      type: "GET",
      data: { selfregister_id: window.selfregister_id },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          let tableContent = "";
          if (response.data.length > 0) {
            $.each(response.data, function (index, item) {
              tableContent += `<tr>
                                              <td>${item.item_id}</td>
                                              <td>${item.product_name}</td>
                                              <td>${item.quantity}</td>
                                              <td>${item.price} 円</td>
                                          </tr>`;
            });
          } else {
            tableContent = '<tr><td colspan="4">カートが空です</td></tr>';
          }
          $("#cart-items tbody").html(tableContent);
        } else {
          console.error("データ取得エラー:", response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAXエラー:", status, error);
      },
    });
  }

  // 初回読み込み
  updateCartItems();

  // 2秒ごとにデータ更新
  setInterval(updateCartItems, 2000);
});
