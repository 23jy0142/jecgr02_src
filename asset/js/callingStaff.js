function callingStaff(selfregister_id) {
  if (selfregister_id) {
    console.error("❌ selfregister_id が未定義です");
    alert("レジIDが取得できません");
    return;
  }

  console.log("📡 スタッフ呼び出し中...");

  fetch("../../dao/update_status.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      selfregister_id: selfregister_id,
      status: "3",
    }),
  })
    .then((response) => response.text())
    .then((responseText) => {
      console.log("✅ スタッフ呼び出し成功:", responseText);
      alert("スタッフを呼び出しました");
      window.location.href = "../../view/self_register/callingStaff.php";
    })
    .catch((error) => {
      console.error("❌ スタッフ呼び出しエラー:", error);
    });
}
