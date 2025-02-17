<?php
require_once 'cart_functions.php';

$selfregister_id = 101;
delete_cart_items($selfregister_id);

// 支払い方法を取得
$method = isset($_GET['method']) ? $_GET['method'] : '不明';

// お釣り情報を取得
$total_amount = isset($_GET['total_amount']) ? intval($_GET['total_amount']) : 0;
$input_amount = isset($_GET['input_amount']) ? intval($_GET['input_amount']) : 0;
$change = max($input_amount - $total_amount, 0);
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
    <script>
        // 5秒後に自動でホーム画面（index.php）へ遷移
        setTimeout(function() {
            window.location.href = "index.php";
        }, 5000);
    </script>
</head>
<body>

    <h1>支払い完了</h1>
    <p>お支払い方法: <?= htmlspecialchars($method, ENT_QUOTES, 'UTF-8') ?></p>

    <?php if ($method === "cash"): ?>
        <p>合計金額: <?= $total_amount ?> 円</p>
        <p>投入金額: <?= $input_amount ?> 円</p>
        <p><strong>おつり: <?= $change ?> 円</strong></p>
    <?php endif; ?>

    <p>5秒後にホーム画面に戻ります...</p>
    <button onclick="location.href='index.php'">ホームに戻る</button>

</body>
</html>
