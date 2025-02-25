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
        let requiresAgeVerification = "2"; // 年齢確認が必要か判定
        let totalQuantity = 0;
        let totalPrice = 0;
        if (response.success) {
          let tableContent = "";

          if (response.data.length > 0) {
            $.each(response.data, function (index, item) {
              console.log("商品データ:", item); // 各商品データを確認

              tableContent += `<tr>
                                  <td>${item.item_id}</td>
                                  <td>${item.product_name}</td>
                                  <td>${Math.floor(item.quantity)}点</td>
                                  <td>${Math.floor(item.price)} 円</td>
                              </tr>`;
              // 合計点数と合計金額を計算
              
              totalQuantity += parseInt(item.quantity);
              totalPrice += parseInt(item.price);

              // `<tfoot>` に合計値を反映
              $("#cart-items tfoot").html(`
                <tr>
                  <td colspan="2"><strong>合計</strong></td>
                  <td><strong>${totalQuantity}</strong> 点</td>
                  <td><strong>${Math.floor(totalPrice)} 円</strong></td>
                </tr>
              `);
              $("#cart-items tbody").html(tableContent);
              console.log("合計点数:", totalQuantity, "合計金額(税抜き):", Math.floor(totalPrice));


              // もし age_verification が true なら年齢確認を行う
              console.log(item.age_verification);
              if (item.age_verification == "2") {
                console.log(
                  "年齢確認が必要な商品がありました:",
                  item.product_name
                );
                requiresAgeVerification = "1";
              }
            });
          }
          $("#cart-items tbody").html(tableContent);
          console.log("requiresAgeVerification の値:", requiresAgeVerification);
          window.requiresAgeVerification = requiresAgeVerification; // これを追加
          // 年齢確認が必要な商品が含まれていたら ageConfig.php に遷移
          // if (requiresAgeVerification == "1") {
          //   console.log("年齢確認が必要なため、ステータスを更新して遷移");

          //   $.ajax({
          //     url: "../../dao/update_status.php",
          //     type: "POST",
          //     data: { selfregister_id: window.selfregister_id, status: "3" }, // ステータスを「3」に更新
          //     success: function () {
          //       console.log("ステータス更新成功");
          //       console.log("画面遷移を実行: ageConfig.php");
          //       window.location.href = "../../view/self_register/ageConfig.php"; // 年齢確認画面へ遷移
          //     },
          //     error: function (xhr, status, error) {
          //       console.error("ステータス更新エラー:", status, error);
          //     },
          //   });
          // }
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
