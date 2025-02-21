<?php
require_once '../../dao/cart_functions.php';
require_once '../../dao/db_connect.php';
require_once '../../dao/add_sales_items.php';

session_start();
$selfregister_id = $_SESSION['selfregister_id'] ?? null;

if (!$selfregister_id) {
    die("❌ セッションに selfregister_id がありません");
}

try {
    // カート内の商品取得
    $cart_items = get_cart_items($selfregister_id);
    
    if (empty($cart_items)) {
        die("❌ カート内の商品がありません");
    }

    // 合計金額を計算
    $total_amount = 0;
    $total_amount_tax = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
        $total_amount_tax = $total_amount * 1.1;
    }

    // 支払い方法の取得
    $method = $_GET['method'] ?? '不明';
    $input_amount = $_GET['input_amount'] ?? 0;
    $change = max($input_amount - $total_amount_tax, 0);

    // 支払情報を　trading_information テーブルに取得
    $pdo = db_connect();
    // ブランチオフィス内にデータを挿入
    $insert_office = get_branch_office($selfregister_id);
    $stmt = $pdo->prepare("INSERT INTO trading_information(selfregister_id,branchoffice_id,trading_time)
                           VALUES(:selfregister_id,'A001',NOW())");
    $stmt->bindParam(':selfregister_id',$selfregister_id,PDO::PARAM_STR);
    $stmt->execute();

    // trading_informationからtrading_idのMAX値を取得
    // 支払い情報を sales_items テーブルに記録
    $trading_information_id=get_trading_id($selfregister_id);
    $insert_items = get_cart_items($selfregister_id);
    $stmt = $pdo->prepare("INSERT INTO sales_items(trading_information_id,item_id,selfregister_id,quantity,payment_date)
                           VALUES(:trading_information_id,:item_id,:selfregister_id,:quantity,NOW())");
    foreach ($insert_items as $item){
        $stmt->execute([
            ':trading_information_id'=> $trading_information_id,
            ':item_id'=> $item['item_id'],
            ':selfregister_id' => $selfregister_id,
            ':quantity'=> $item['quantity']
        ]);
    }

    /**
    * カートにアイテムを追加する
    **/
    // サンプルコード
    // function addCartItem($selfregister_id, $item_id, $quantity) {
    //     $pdo = db_connect();
        // $stmt = $pdo->prepare("INSERT INTO cart_items (selfregister_id, item_id, quantity) VALUES (:selfregister_id, :item_id, :quantity)
        //     ON DUPLICATE KEY UPDATE quantity = quantity + :quantity");
    //     $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
    //     $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
    //     $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }

    
    // foreach ($insert_office as $branch_office){
    //     $stmt->execute([
    //         ':selfregister_id' => $selfregister_id,
    //     ]);
    // }
    // カート内の商品を削除
    delete_cart_items($selfregister_id);
    update_selfregister_status($_SESSION['selfregister_id'], "4"); // ステータスを 2 に更新
} catch (Exception $e) {
    die("❌ エラー: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>支払い完了</title>
    <link rel="stylesheet" href="../../asset/css/style/header.css" />
    <link rel="stylesheet" href="../../asset/css/style/main.css" />
    <link rel="stylesheet" href="../../asset/css/style/footer.css" />
    <link rel="stylesheet" href="../../asset/css/component/sidebar.css" />
    <link rel="stylesheet" href="../../asset/css/component/content.css" />
    <link rel="stylesheet" href="../../asset/css/component/container.css">
    <link rel="stylesheet" href="../../asset/css/component/box.css">
    <link rel="stylesheet" href="../../asset/css/component/button.css" />
    <link rel="stylesheet" href="../../asset/css/component/table.css">
    <link rel="stylesheet" href="../../asset/css/component/text.css" />
    <link rel="stylesheet" href="../../asset/css/style/all.css" />
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 15000);
    </script>
</head>
<body onload="startClock()">
     <!-- ヘッダー部分 -->
     <div class="header">
      <header class="header_left">
        
      </header>
      <div class="header_right">
        <span id="now"></span>
      </div>
    </div>
    <!-- メイン部分 -->
    <div class="main">
      <div class="container">
        <h1 id = "center_msg">ご利用ありがとうございます。</h1><br>
        <div class="content">
          <h2 id="under_msg">お釣りの取り忘れにご注意ください</h2>
          <div class="change_pay">
              <h2>おつり</h2>
              <p><strong class="change_text">おつり: <?= $change?> 円</strong></p>
          </div>
        </div>
      </div>
      <button onclick="createReceipt()">レシート発行</button>
    </div>
    <div class="footer">
        <div class="btn_box">
            <button onclick="location.href='index.php'">ホームに戻る</button>
        </div>
    </div>
    <script type="module" src="../../asset/js/time.js"></script>
    <script type="module" src="../../asset/create_receipt.js"></script>
</body>
</html>
