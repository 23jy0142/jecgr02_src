<?php
session_start();
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';

// セッションから selfregister_id を取得
if (!isset($_SESSION['selfregister_id'])) {
    die("エラー: レジIDが設定されていません");
}
$selfregister_id = $_SESSION['selfregister_id'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お支払い方法</title>
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
        // PHP から selfregister_id を JavaScript に渡す
        window.selfregister_id = <?= json_encode($selfregister_id) ?>;
    </script>
</head>
<body onload="startClock()">
    <div class="header">
        <header class="header_left"></header>
            <div class="header_right">
                <span id="now"></span>
            </div>
        </div>
    <div class="main">
        <h1 id="center_msg">お支払方法の選択</h1>
        <div class="rows">
            <button class="btn_green2 btn" onclick="location.href='cash_payment.php?method=cash'">現金</button>
            <button class="btn_gray2 btn" onclick="location.href='credit_payment.php?method=credit'">クレジット</button>
        </div>
    </div>
    <footer>
    <div class="footer">
        <div class="btn_box">
            <button class="btn_gray btn" onclick="callingStaff()">呼び出し</button>
            <button class="btn_red btn" onclick="cancelTransaction()">取引中止</button>
            <button class="btn_white btn" onclick="location.href='cart.php'">戻る</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../asset/js/callingStaff.js"></script>
    <script src="../../asset/js/cancelTransaction.js"></script>
    <script src="../../asset/js/time.js"></script>
</footer>
</body>
</html>
