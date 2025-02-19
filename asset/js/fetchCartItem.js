$(document).ready(function () {
  function updateCartItems() {
    $.ajax({
      url: "../../dao/fetch_cart_items.php", // 非同期でデータ取得
      type: "GET",
      data: { selfregister_id: window.selfregister_id },
      dataType: "json",
      success: function (response) {
        console.log("サーバーからのレスポンス:", response); // データの確認
        console.log(response.data);
        let requiresAgeVerification = false; // 年齢確認が必要か判定
        if (response.success) {
          let tableContent = "";

          if (response.data.length > 0) {
            $.each(response.data, function (index, item) {
              console.log("商品データ:", item); // 各商品データを確認

              tableContent += `<tr>
                                  <td>${item.item_id}</td>
                                  <td>${item.product_name}</td>
                                  <td>${item.quantity}</td>
                                  <td>${item.price} 円</td>
                              </tr>`;

              // もし age_verification が true なら年齢確認を行う
              console.log(item.age_verification);
              if (item.age_verification == "1") {
                console.log(
                  "年齢確認が必要な商品がありました:",
                  item.product_name
                );
                requiresAgeVerification = true;
              }else{
                
              } 
            });
          } else {
            tableContent = '<tr><td colspan="4">カートが空です</td></tr>';
          }
          $("#cart-items tbody").html(tableContent);
          console.log("requiresAgeVerification の値:", requiresAgeVerification);

          // 年齢確認が必要な商品が含まれていたら ageConfig.php に遷移
          if (requiresAgeVerification == "1") {
            console.log("年齢確認が必要なため、ステータスを更新して遷移");

            $.ajax({
              url: "../../dao/update_status.php",
              type: "POST",
              data: { selfregister_id: window.selfregister_id, status: "3" }, // ステータスを「3」に更新
              success: function () {
                console.log("ステータス更新成功");
                console.log("画面遷移を実行: ageConfig.php");
                window.location.href = "../../view/self_register/ageConfig.php"; // 年齢確認画面へ遷移
              },
              error: function (xhr, status, error) {
                console.error("ステータス更新エラー:", status, error);
              },
            });
          }
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
