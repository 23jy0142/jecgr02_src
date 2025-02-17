<?php
require_once 'cart_functions.php';

$selfregister_id = 101;
delete_cart_items($selfregister_id);

$method = isset($_GET['method']) ? $_GET['method'] : '不明';
$message = "お支払いが完了しました（支払い方法：$method）";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>支払い完了</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        button { font-size: 16px; padding: 10px 20px; margin-top: 10px; cursor: pointer; }
    </style>
</head>
<body>

    <h1>支払い完了</h1>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="location.href='index.php'">ホームに戻る</button>

</body>
</html>
