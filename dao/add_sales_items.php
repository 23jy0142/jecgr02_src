<?php
require_once 'db_connect.php';
require_once 'cart_functions.php';

function record_payment($selfregister_id, $total_amount, $method) {
  $INSERT_items = get_cart_items($selfregister_id);
    try {
        $pdo = db_connect();

        // INSERT文を実行
        $stmt = $pdo->prepare("
            INSERT INTO sales_items (item_id,selfregister_id,quantity, payment_date)
            VALUES(:item_id,:selfregister_id,:quantity,NOW())");

            foreach ($INSERT_items as $item){
              $stmt->execute([
                  ':item_id' => $item['item_id'],
                  ':selfregister_id' => $selfregister_id,
                  ':quantity' => $item['quantity']
              ]);
          }

        return true;
    } catch (PDOException $e) {
        die("❌ データベースエラー: " . $e->getMessage());
    }
}
?>
