function pauseRegister() {
  $.ajax({
    url: "../../dao/update_status.php",
    type: "POST",
    data: { status: "5" },
    success: function (response) {
      console.log("レスポンス:", response);
      if (response.trim() === "success") {
        window.location.href = "../../view/selfregister/pause.php";
      } else {
        alert("ステータス更新に失敗しました: " + response);
      }
    },
    error: function (xhr, status, error) {
      console.error("通信エラー:", status, error);
      alert("通信エラーが発生しました");
    },
  });
}
