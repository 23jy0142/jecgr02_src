<?php
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';
session_start();
$selfregister_id = $_SESSION['selfregister_id'];
$cart_items = get_cart_items($selfregister_id);
update_selfregister_status($selfregister_id, "2"); // ステータスを 2 に更新

// 合計金額を計算
$total_amount = 0;
$total_amount_tax = 0;
$total_quantity = 0;
foreach ($cart_items as $item) {
    $total_amount += floor($item['price'] * $item['quantity']);
    $total_quantity += $item['quantity'];
}
$total_amount_tax += floor($total_amount * 1.1);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>クレジット支払い</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        input { font-size: 16px; padding: 5px; margin-top: 5px; width: 200px; }
        button { font-size: 16px; padding: 10px 20px; margin-top: 10px; cursor: pointer; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // PHP から selfregister_id を JavaScript に渡す
        window.selfregister_id = <?= json_encode($selfregister_id) ?>;
    </script>
</head>
<body onload="startClock()">
    <!-- ヘッダー部分 -->
    <div class="header">
        <header class="header_left"></header>
        <div class="header_right">
            <span id="now"></span>
        </div>
    </div>
    <div class="rows">
        <div class="left_box">
            <div class="pay_box">
                <div><h2 id="pay_text">合計金額:</h2> <span id="total-amount" data-total="<?= $total_amount ?>"><?= $total_amount_tax?> 円</span></div>
                <div><h2 id="pay_text">合計点数:</h2> <span id="total-quantity" data-total="<?= $total_quantity ?>"><?= $total_quantity ?> 点</span></div>
            </div>
        </div>
        <!-- 画面全体の右部分 -->
        <div class="right_box">
            <div class="righttext_box">
                <p id="payexp_text">カードを挿入<i class="fa-solid fa-arrow-right" style="color: #96be86;"></i></p>
                <p id="payexp_text">してください</p>
            </div>
            <div><button class="btn" onclick="location.href='credit_complete.php'">「疑似操作」カードを挿入</button></div>
        </div>
    </div>
    
    

<footer>
    <div class="footer">
        <div class="btn_box">
            <button class="btn_gray btn" onclick="callingStaff()">呼び出し</button>
            <button class="btn_red btn" onclick="cancelTransaction()">取引中止</button>
            <button class="btn_white btn" onclick="location.href='payment.php'">戻る</button>
        </div>
    </div>
    
    <script src="../../asset/js/callingStaff.js"></script>
    <script src="../../asset/js/cancelTransaction.js"></script>
    <script src="../../asset/js/time.js"></script>
</footer>
</body>
</html>
