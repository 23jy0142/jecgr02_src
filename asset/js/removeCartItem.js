// カートからアイテム削除
function removeCartItem(item_id) {
  fetch("../../dao/remove_cart_item.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ selfregister_id, item_id }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        console.log("✅ 削除成功");
        location.reload();
      } else {
        console.error("❌ 削除エラー:", data.error);
      }
    });
}
