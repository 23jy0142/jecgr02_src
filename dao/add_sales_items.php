<?php
require_once 'db_connect.php';
require_once 'cart_functions.php';

function record_payment($selfregister_id, $total_amount, $method) {
  $INSERT_items = get_cart_items($selfregister_id);
  $insert_office = get_branch_office($selfregister_id);
  print($insert_office);
    try {
        $pdo = db_connect();

        // INSERT文を実行
        $stmt = $pdo->prepare("
            INSERT INTO trading_information (selfregister_id,branchoffice_id, trading_time)
            VALUES(:selfregister_id,:branchoffice_id,NOW())");

            foreach ($INSERT_items as $item){
              $stmt->execute([
                  ':selfregister_id' => $selfregister_id,
                  ':branchoffice_id' => $branch_office['branchoffice_id']
              ]);
          }
        return true;
    } catch (PDOException $e) {
        die("❌ データベースエラー: " . $e->getMessage());
    }
}
?>
