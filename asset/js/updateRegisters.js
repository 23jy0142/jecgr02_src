function updateRegisters() {
  $.ajax({
    url: "../../dao/fetch_register_data.php",
    type: "GET",
    dataType: "json",
    success: function (response) {
      console.log("🚀 AJAX Response:", response); // デバッグログ

      if (!response.success) {
        console.error("❌ Fetch Failed:", response.error);
        return;
      }

      $("#register-container").html("");

      response.data.forEach((register) => {
        console.log(`ℹ️ レジ ${register.selfregister_id} のデータ:`, register);

        let notificationText = "";
        let notificationClass = "";
        let registerContent = "";

        if (register.selfregister_status == "3") {
          notificationText = "⚠️ スタッフ呼び出し";
          notificationClass = "active";
        } else if (register.selfregister_status == "4") {
          notificationText = "✅ お会計完了";
          notificationClass = "active";
        } else if (register.selfregister_status == "6") {
          notificationText = "✅ 取引中止";
          notificationClass = "active";
        }

        // 休止中のレジは「休止中」画面を表示
        if (register.selfregister_status == "5") {
          registerContent = `<div class="register-paused">休止中</div>`;
        } else {
          registerContent = `
                      <div class='total-amount'>合計金額: ${Math.floor(
                        register.total_price
                      )} 円</div>
                      <div class='register-content'>
                          <div class='items'>
                              <table>
                                  <thead>
                                      <tr>
                                          <th>JANコード</th>
                                          <th>商品名</th>
                                          <th>個数</th>
                                          <th>金額</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      ${
                                        register.items.length > 0
                                          ? register.items
                                              .map(
                                                (item) => `
                                          <tr>
                                              <td>${item.item_id}</td>
                                              <td>${item.product_name}</td>
                                              <td>${item.quantity}</td>
                                              <td>${Math.floor(
                                                item.price
                                              )} 円</td>
                                          </tr>
                                      `
                                              )
                                              .join("")
                                          : `<tr><td colspan='4'>カートが空です</td></tr>`
                                      }
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  `;
        }

        let registerHTML = `
                  <div class='register-box' id='register-${register.selfregister_id}'>
                      <div class='register-header'>${register.selfregister_id}番レジ</div>
                      ${registerContent}
                      <div class='notification ${notificationClass}' id='notification-${register.selfregister_id}'>
                          ${notificationText}
                          <button onclick='clearNotification(${register.selfregister_id})'>〆</button>
                      </div>
                  </div>
              `;

        $("#register-container").append(registerHTML);
      });
    },
    error: function (xhr, status, error) {
      console.error("❌ AJAX Error:", status, error);
    },
  });
}
