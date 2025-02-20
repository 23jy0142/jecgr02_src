function createReceipt(){
  if(!window.selfregister_id){
    console.log("✖ selfregister_idが未定義です");
    alert("レジIDが取得できません");
    return;
  }
  console.log("お支払い中...");

  fetch("../../dao/create_receipt.php",{
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      selfregister_id: window.selfregister_id,
    }),
  })
  .then((response) => response.text())
    .then((responseText) => {
      console.log("✅ レシート作成処理成功:", responseText);
      window.location.href = "../../view/self_register/payment.php";
    })
    .catch((error) => {
      console.error("❌ お支払いエラー:", error);
      alert("お支払い処理に失敗しました");
    });
}