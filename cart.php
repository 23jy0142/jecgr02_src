<?php
$selfregister_id = 101; // レジのID
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
    <script>
        $(document).ready(function() {
            function updateCartItems() {
                $.ajax({
                    url: 'fetch_cart_items.php', // 非同期でデータ取得
                    type: 'GET',
                    data: { selfregister_id: <?= $selfregister_id ?> },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            let tableContent = '';
                            if (response.data.length > 0) {
                                $.each(response.data, function(index, item) {
                                    tableContent += `<tr>
                                                        <td>${item.item_id}</td>
                                                        <td>${item.product_name}</td>
                                                        <td>${item.quantity}</td>
                                                        <td>${item.price} 円</td>
                                                    </tr>`;
                                });
                            } else {
                                tableContent = '<tr><td colspan="4">カートが空です</td></tr>';
                            }
                            $('#cart-items tbody').html(tableContent);
                        } else {
                            alert('データの取得に失敗しました: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAXエラー:', status, error);
                    }
                });
            }

            // 初回読み込み
            updateCartItems();

            // 2秒ごとにデータ更新
            setInterval(updateCartItems, 2000);
        });
    </script>
</head>
<body>

    <h1>カート情報</h1>
    <table id="cart-items">
        <thead>
            <tr>
                <th>JANコード</th>
                <th>商品名</th>
                <th>個数</th>
                <th>金額</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <button onclick="location.href='payment.php'">お支払いへ</button>

</body>
</html>
