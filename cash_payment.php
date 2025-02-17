<?php
require_once 'cart_functions.php';
$selfregister_id = 101;
$cart_items = get_cart_items($selfregister_id);

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
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        input { font-size: 16px; padding: 5px; margin-top: 5px; width: 200px; }
        button { font-size: 16px; padding: 10px 20px; margin-top: 10px; cursor: pointer; }
    </style>
    <script>
        function calculateChange() {
            var totalAmount = <?= $total_amount ?>;
            var inputAmount = parseInt(document.getElementById('input-amount').value) || 0;
            var change = inputAmount - totalAmount;

            document.getElementById('total-amount').innerText = totalAmount + ' 円';
            document.getElementById('change').innerText = (change >= 0 ? change : 0) + ' 円';
            document.getElementById('shortage').innerText = (change < 0 ? Math.abs(change) : 0) + ' 円';

            document.getElementById('complete-payment').disabled = (change < 0);
            document.getElementById('complete-payment').setAttribute("onclick", 
                `location.href='complete.php?method=cash&total_amount=${totalAmount}&input_amount=${inputAmount}'`);
        }
    </script>
</head>
<body>
    <h1>現金でのお支払い</h1>
    <div>合計金額: <span id="total-amount"><?= $total_amount ?> 円</span></div>
    <div>
        投入金額: <input type="number" id="input-amount" placeholder="投入金額" oninput="calculateChange()">
    </div>
    <div>おつり: <span id="change">0 円</span></div>
    <div>不足金額: <span id="shortage">0 円</span></div>
    <button id="complete-payment" disabled>お支払い完了</button>
</body>
</html>
