function goToPayment() {
  if (!window.selfregister_id) {
    console.error("❌ selfregister_id が未定義です");
    alert("レジIDが取得できません");
    return;
  }

  console.log("📡 お支払い処理中...");

  fetch("/src/dao/update_status.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      selfregister_id: window.selfregister_id,
      status: "2",
    }),
  })
    .then((response) => response.text())
    .then((responseText) => {
      console.log("✅ お支払い処理成功:", responseText);
      window.location.href = "/src/view/self_register/payment.php";
    })
    .catch((error) => {
      console.error("❌ お支払いエラー:", error);
      alert("お支払い処理に失敗しました");
    });
}
