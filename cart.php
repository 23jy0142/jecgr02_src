<?php
require_once 'cart_functions.php';
$cart_items = get_cart_items(101);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>カート情報</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #f4f4f4; }
        button { font-size: 16px; padding: 10px 20px; margin-top: 10px; cursor: pointer; }
    </style>
</head>
<body>

    <h1>カート情報</h1>
    <table>
        <thead>
            <tr>
                <th>JANコード</th>
                <th>商品名</th>
                <th>個数</th>
                <th>金額</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?= $item['item_id'] ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['price'] ?> 円</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button onclick="location.href='payment.php'">お支払いへ</button>

</body>
</html>
