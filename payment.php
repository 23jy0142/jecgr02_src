<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お支払い方法</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        button { font-size: 16px; padding: 10px 20px; margin: 10px; cursor: pointer; }
    </style>
</head>
<body>

    <h1>お支払い方法の選択</h1>
    <button onclick="location.href='cash_payment.php?method=cash'">現金</button>
    <button onclick="location.href='cash_payment.php?method=credit'">クレジット</button>

</body>
</html>
