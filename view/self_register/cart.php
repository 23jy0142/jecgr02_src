<?php
session_start();
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';

// セッションから selfregister_id を取得
if (!isset($_SESSION['selfregister_id'])) {
    die("エラー: レジIDが設定されていません");
}
$selfregister_id = $_SESSION['selfregister_id'];
update_selfregister_status($selfregister_id, "1"); // ステータスを 1 に更新
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/style/header.css" />
    <link rel="stylesheet" href="../../asset/css/style/main.css" />
    <link rel="stylesheet" href="../../asset/css/style/footer.css" />
    <link rel="stylesheet" href="../../asset/css/component/sidebar.css" />
    <link rel="stylesheet" href="../../asset/css/component/content.css" />
    <link rel="stylesheet" href="../../asset/css/component/container.css">
    <link rel="stylesheet" href="../../asset/css/component/box.css">
    <link rel="stylesheet" href="../../asset/css/component/button.css" />
    <!-- <link rel="stylesheet" href="../../asset/css/component/table.css"> -->
    <link rel="stylesheet" href="../../asset/css/component/text.css" />
    <link rel="stylesheet" href="../../asset/css/style/all.css" />
    <title>セルフレジ　会計画面</title>
    <script>
        // PHP から selfregister_id を JavaScript に渡す
        window.selfregister_id = <?= json_encode($selfregister_id) ?>;
    </script>
    <style>
        /* body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #f4f4f4; }
        button { font-size: 16px; padding: 10px 20px; margin-top: 10px; cursor: pointer; } */
    </style>
</head>
<body onload="startClock()">
<div class="header">
    <header class="header_left"></header>
        <div class="header_right">
            <span id="now"></span>
        </div>
    </div>
    <div class="main">
    <h1>カート内容</h1>
        <div class="box_container">
            
            <table id="cart-items">
                <thead>
                    <tr>
                        <th>JANコード</th>
                        <th>商品名</th>
                        <th>個数</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 非同期でデータが挿入される -->
                </tbody>
            </table>
            </div>
        </div> 
    </div>
    

    
    <button class="btn_red btn" >取引中止</button>
    <button class="btn_green"  onclick="goToPayment()" style="font-size: 16px;">お支払いへ</button>
    <button class="btn_gray btn"  onclick="callingStaff()" >スタッフ呼び出し</button>
    <a class="btn_yellow btn"  href="cart_edit_login.php">商品入力</a>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../../asset/js/fetchCartItem.js"></script>
    <script src="../../asset/js/callingStaff.js"></script>
    <script src="../../asset/js/goToPayment.js"></script>
    <script src="../../asset/js/time.js"></script>

</body>
</html>
