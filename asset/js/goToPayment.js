// function goToPayment() {
//   if (!window.selfregister_id) {
//     console.error("❌ selfregister_id が未定義です");
//     alert("レジIDが取得できません");
//     return;
//   }

//   console.log("📡 お支払い処理中...");

//   fetch("../../dao/update_status.php", {
//     method: "POST",
//     headers: { "Content-Type": "application/x-www-form-urlencoded" },
//     body: new URLSearchParams({
//       selfregister_id: window.selfregister_id,
//       status: "2",
//     }),
//   })
//     .then((response) => response.text())
//     .then((responseText) => {
//       console.log("✅ お支払い処理成功:", responseText);
//       window.location.href = "../../view/self_register/payment.php";
//     })
//     .catch((error) => {
//       console.error("❌ お支払いエラー:", error);
//       alert("お支払い処理に失敗しました");
//     });
// }
function goToPayment() {
  if (!window.selfregister_id) {
    console.error("❌ selfregister_id が未定義です");
    alert("レジIDが取得できません");
    return;
  }

  // 年齢確認が必要な場合の処理
  if (window.requiresAgeVerification === "1") {
    console.log("年齢確認が必要なため、ステータスを更新して遷移");

    fetch("../../dao/update_status.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        selfregister_id: window.selfregister_id,
        status: "3", // ステータスを「3」に更新
      }),
    })
      .then((response) => response.text())
      .then((responseText) => {
        console.log("✅ ステータス更新成功:", responseText);
        console.log("🔄 年齢確認画面へ遷移: ageConfig.php");
        window.location.href = "../../view/self_register/ageConfig.php";
      })
      .catch((error) => {
        console.error("❌ ステータス更新エラー:", error);
        alert("年齢確認の処理に失敗しました");
      });

    return; // 年齢確認が必要な場合はここで処理を終了
  }

  // 年齢確認が不要ならそのまま決済へ進む
  fetch("../../dao/update_status.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      selfregister_id: window.selfregister_id,
      status: "2", // ステータスを「2」に更新
    }),
  })
    .then((response) => response.text())
    .then((responseText) => {
      console.log("✅ お支払い処理成功:", responseText);
      window.location.href = "../../view/self_register/payment.php";
    })
    .catch((error) => {
      console.error("❌ お支払いエラー:", error);
      alert("お支払い処理に失敗しました");
    });
}
