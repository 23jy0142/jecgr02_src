<?php
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';
session_start();
$selfregister_id = $_SESSION['selfregister_id'];
$cart_items = get_cart_items($selfregister_id);
update_selfregister_status($selfregister_id, "2"); // ステータスを 2 に更新

// 合計金額を計算
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>現金支払い</title>
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
</head>
<body onload="startClock()">
    <!-- ヘッダー部分 -->
    <div class="header">
        <header class="header_left"></header>
        <div class="header_right">
            <span id="now"></span>
        </div>
    </div>
    <div class="main">
        <div class="left_box1">
            <div class="pay_box">
                <div><h2 id="pay_text">合計金額:</h2> <span id="total-amount" data-total="<?= $total_amount ?>"><?= $total_amount ?> 円</span></div>
                <div><h2 id="pay_text">投入金額:</h2> <input type="number" id="input-amount" placeholder="投入金額" oninput="calculateChange()"></div>
                <div><h2 id="enoughpay_text">おつり:</h2> <span id="change">0 円</span></div>
                <div><h2 id="pay_text">不足金額:</h2> <span id="shortage"><?= $total_amount ?> 円</span></div>
                <button id="complete-payment" disabled>お支払い完了</button>
            </div>
        </div>
        <!-- 画面全体の右部分 -->
        <div class="right_box1">
            <div class="righttext_box">
                <p id="payexp_text"><i class="fa-solid fa-arrow-left" style="color: #96be86;"></i> お金を投入してください</p>
            </div>
        </div>
    </div>
    
    

<footer>
    <div class="container">
        <button class="btn_gray btn" onclick="callingStaff()">呼び出し</button>
        <button class="btn_red btn" onclick="">取引中止</buttonｃ>
    </div>
    
    <script src="../../asset/js/callingStaff.js"></script>
    <script src="../../asset/js/calculateChange.js"></script>
</footer>
</body>
</html>
