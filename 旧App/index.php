<?php
require_once 'db_connect.php';
require_once 'cart_functions.php';

$selfregister_id = "101";
update_selfregister_status($selfregister_id, "1"); // ステータスを 1 に更新
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>いらっしゃいませ</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        button { font-size: 18px; padding: 14px 28px; cursor: pointer; }
    </style>
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<body>
    <div class="header_right">
        <span id="now"></span>
    </div>
    <h1>いらっしゃいませ</h1>
    <button onclick="location.href='cart.php'">開始</button>
    <button onclick="callingStaff()">呼び出し</button>
    <!-- <button onclick="pauseConfirmation()">休止</button> -->
    <footer>
        <button onclick="location.href='pause_confirmation.php'">休止</button>
    </footer>
    <script src="callingStaff.js"></script>
</body>
</html>
