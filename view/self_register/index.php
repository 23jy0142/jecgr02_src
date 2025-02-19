<?php 
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';

session_start();
// ✅ `selfregister_id` が未設定ならデフォルト値をセット
if (!isset($_SESSION['selfregister_id'])) {
  $_SESSION['selfregister_id'] = 101; // デフォルト値（本来はDBから取得すべき）
}
$selfregister_id = $_SESSION['selfregister_id'];
update_selfregister_status($_SESSION['selfregister_id'], "2"); // ステータスを 2 に更新
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>いらっしゃいませ</title>
    
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
    <!-- ✅ PHPで背景画像を直接適用 -->
    <style>
        /* body {
            background-image: url("../../asset/image/background_image1.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        } */
    </style>
    <script>
        window.selfregister_id = <?= json_encode($selfregister_id)?>;
        console.log("selfregister_id:",window.selfregister_id);
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
    <div class="main">
        <div class="container">
        <h1 id="center_msg">いらっしゃいませ</h1>
        </div>
    </div>
    
    
    <!-- <button onclick="pauseConfirmation()">休止</button> -->
    <footer>
        
    </footer>

    <div class="footer">
        <div class="btn_box">
            <button class="btn_blue btn" onclick="location.href='cart.php'">開始</button>
            <button class="btn_blue btn" onclick="callingStaff()">呼び出し</button>
            <button class="btn_gray btn" onclick="location.href='pause_confirmation.php'">休止</button> 
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module" src="../../config/cartConfig.js" defer></script>
    <script src="../../asset/js/callingStaff.js"></script>
    <script type="module" src="../../asset/js/time.js"></script>
</body>
</html>