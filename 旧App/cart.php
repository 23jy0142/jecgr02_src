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
                            console.error('データ取得エラー:', response.message);
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
        function goToPayment() {
            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: { status: '2' },
                success: function(response) {
                    if (response.trim() === 'success') {
                        window.location.href = 'payment.php';
                    } else {
                        alert('ステータス更新に失敗しました');
                    }
                },
                error: function() {
                    alert('通信エラーが発生しました');
                }
            });
        }
        function callingStaff() {
            $.ajax({
                url: 'update_status.php',
                type: 'POST',
                data: { status: '3' },
                success: function(response) {
                    if (response.trim() === 'success') {
                        window.location.href = 'callingStaff.php';
                    } else {
                        alert('ステータス更新に失敗しました');
                    }
                },
                error: function() {
                    alert('通信エラーが発生しました');
                }
            });
        }
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

    <button onclick="goToPayment()">お支払いへ</button>
    <a href="cart_edit_login.php">商品入力</a>
    <button onclick="callingStaff()">呼び出し</button>
</body>
</html>
