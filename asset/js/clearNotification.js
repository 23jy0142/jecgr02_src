function clearNotification(register_id) {
  $.ajax({
      url: '../../dao/update_register_status.php',
      type: 'POST',
      data: { selfregister_id: register_id, status: '1' },
      success: function() {
          // 通知エリアをフェードアウトして非表示にする
          $(`#notification-${register_id}`).fadeOut(300, function () {
              $(this).remove();
          });
      },
      error: function(xhr, status, error) {
          console.error("❌ 通知削除エラー:", status, error);
      }
  });
}
