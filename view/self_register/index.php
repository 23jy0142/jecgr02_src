<?php 
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';

session_start();
// ✅ `selfregister_id` が未設定ならデフォルト値をセット
if (!isset($_SESSION['selfregister_id'])) {
  $_SESSION['selfregister_id'] = 101; // デフォルト値（本来はDBから取得すべき）
}
$selfregister_id = $_SESSION['selfregister_id'];
// update_selfregister_status($_SESSION['selfregister_id'], "2"); // ステータスを 2 に更新
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
        #secretButton {
            opacity: 0; /* 透明にする */
            position: absolute; /* ページ内の適切な位置に配置 */
            top: 10px; /* 例: 上部10px */
            left: 10px; /* 例: 左端から10px */
            width: 50px; /* 小さめの範囲にする */
            height: 30px;
            z-index: 1000; /* 他の要素より前面に配置 */
            cursor: pointer; /* クリックできるように */
        }
    </style>
    <script>
        window.selfregister_id = <?= json_encode($selfregister_id)?>;
        console.log("selfregister_id:",window.selfregister_id);

        document.addEventListener("DOMContentLoaded", function() {
    let clickCount = 0;
    let timer;
    const button = document.getElementById('secretButton');

    if (button) { // ボタンが存在するか確認
        button.addEventListener('click', function() {
            clickCount++;

            // 最初のクリックでタイマーをセット
            if (clickCount === 1) {
                timer = setTimeout(function() {
                    clickCount = 0; // 5秒後にリセット
                }, 5000);
            }

            // クリック数が3回に達したら
            if (clickCount >= 3) {
                clearTimeout(timer);
                window.location.href = '../dashboard/dashboard_login.php'; // 遷移先
            }
        });
    } else {
        console.error("ボタンが見つかりません: secretButton");
    }
});

    </script>
</head>

<body onload="startClock()">
    <!-- ヘッダー部分 -->
    <div class="header">
      <header class="header_left">
      <!-- 隠しコマンド用のボタン -->
    <button id="secretButton">管理者ログイン用ボタン</button>
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
    <script src="../../asset/js/time.js"></script>
</body>
</html>