<?php 
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';
session_start();
$selfregister_id = $_SESSION['selfregister_id'];
update_selfregister_status($selfregister_id, "5"); // ステータスを 1 に更新
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
    <link rel="stylesheet" href="../../asset/css/component/table.css">
    <link rel="stylesheet" href="../../asset/css/component/text.css" />
    <title>休止中</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px; background-color: #ccc; }
    h1 { color: #256aff; }
    button { background-color: #9cf;}
</style>

<body class="pouse" onload="startClock()">
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
        <h1>休止中...</h1>
        <div class="saikai_box">
            <button class="btn btn_saikai" onclick="location.href='restart_confirmation.php'">再開</button>
        </div>
    </div>
    <!-- フッター部分 -->
    <div class="footer">
      <div class="container">
        
      </div>
    </div> 
    <script src="../../asset/js/time.js"></script>
</body>
</html>