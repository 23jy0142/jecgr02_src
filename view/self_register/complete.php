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
    foreach ($cart_items as $item) {
        $total_amount += $item['price'] * $item['quantity'];
    }

    // 支払い方法の取得
    $method = $_GET['method'] ?? '不明';
    $input_amount = $_GET['input_amount'] ?? 0;
    $change = max($input_amount - $total_amount, 0);

    // 支払い情報を sales_items テーブルに記録
    $result = record_payment($selfregister_id, $total_amount, $method);

    if (!$result) {
        die("❌ 支払処理に失敗しました");
    }

    // カート内の商品を削除
    delete_cart_items($selfregister_id);
    update_selfregister_status($_SESSION['selfregister_id'], "2"); // ステータスを 2 に更新
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
        // setTimeout(function() {
        //     window.location.href = "index.php";
        // }, 5000);
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
              <p><strong>おつり: <?= $change ?> 円</strong></p>
              <!-- CSSで余白と右寄せを使って作成してみて！ -->
              <p><span class="change_text"></span>円</p>
          </div>
        </div>
      </div>
    </div>
    <button onclick="location.href='index.php'">ホームに戻る</button>
</body>
</html>
