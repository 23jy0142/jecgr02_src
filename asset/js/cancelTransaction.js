function cancelTransaction() {
  if (!window.selfregister_id) {
    console.error("❌ selfregister_id が未定義です");
    alert("取引中止に失敗しました（selfregister_id 不明）");
    return;
  }

  if (!confirm("本当に取引を中止しますか？")) {
    return;
  }

  $.ajax({
    url: "../../dao/delete_cart_items.php",
    type: "POST",
    data: { selfregister_id: window.selfregister_id },
    success: function (response) {
      console.log("✅ サーバーレスポンス:", response);

      if (response.trim() === "success") {
        window.location.href = "../../view/self_register/cancel_transaction.php"; // ✅ index.php へ遷移
      } else {
        console.error("❌ 取引中止に失敗:", response);
        alert("取引中止に失敗しました (" + response + ")");
      }
    },
    error: function (xhr, status, error) {
      console.error("❌ AJAXエラー:", status, error);
      alert("通信エラーが発生しました");
    },
  });
}
