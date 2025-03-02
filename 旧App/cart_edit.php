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
    <title>カート編集</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #f4f4f4; }
        .quantity-control { display: flex; align-items: center; justify-content: center; gap: 10px; }
        .quantity-btn { width: 30px; height: 30px; font-size: 18px; cursor: pointer; border: none; }
        .increase { background-color: #ffb3b3; color: #721c24; }
        .decrease { background-color: #cce5ff; color: #004085; }
        button { font-size: 16px; padding: 10px 20px; margin-top: 10px; cursor: pointer; }
        input { padding: 8px; font-size: 16px; width: 200px; }
        #message { margin-top: 10px; font-size: 14px; color: green; }
        #error-message { margin-top: 10px; font-size: 14px; color: red; }
    </style>
    <script>
        $(document).ready(function() {
            function updateCartItems() {
                $.ajax({
                    url: 'fetch_cart_items.php',
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
                                                        <td class="quantity-control">
                                                            <button class="quantity-btn decrease" data-item-id="${item.item_id}">−</button>
                                                            <span>${item.quantity}</span>
                                                            <button class="quantity-btn increase" data-item-id="${item.item_id}">+</button>
                                                        </td>
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
            setInterval(updateCartItems, 2000);

            // + / - ボタン処理
            $(document).on("click", ".increase, .decrease", function() {
                let itemId = $(this).data("item-id");
                let change = $(this).hasClass("increase") ? 1 : -1;
                updateQuantity(itemId, change);
            });

            function updateQuantity(itemId, change) {
                $.ajax({
                    url: "update_cart_quantity.php",
                    type: "POST",
                    data: { selfregister_id: <?= $selfregister_id ?>, item_id: itemId, change: change },
                    success: function(response) {
                        if (response.trim() !== "success") {
                            console.error("更新失敗:", response);
                        }
                        updateCartItems();
                    },
                    error: function(xhr, status, error) {
                        console.error("数量変更エラー:", status, error);
                    }
                });
            }

            // 商品追加処理
            $("#addItemForm").submit(function(event) {
        event.preventDefault();
        let itemId = $("#item_id").val();
        if (!/^\d{13}$/.test(itemId)) {
            $("#error-message").text("JANコードは13桁の数字のみ入力してください。");
            console.log("エラー: JANコードの形式が不正です:", itemId);
            return;
        }

        $.ajax({
            url: "add_cart_items.php",
            type: "POST",
            data: { selfregister_id: "101", item_id: itemId },
            dataType: "json",
            success: function(response) {
                console.log("サーバーレスポンス:", response);

                if (response.status === "success") {
                    $("#message").text(response.message);
                    $("#error-message").text("");
                    $("#item_id").val("");
                    updateCartItems();
                } else if (response.status === "not_found") {
                    $("#error-message").text(response.message);
                    $("#message").text("");
                } else {
                    $("#error-message").text("エラー: " + response.message);
                    console.log("デバッグ情報:", response.debug);
                    $("#message").text("");
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAXエラー:", status, error);
                console.log("レスポンス内容:", xhr.responseText);
                $("#error-message").text("通信エラーが発生しました。");
            }
        });
    });
        });

        function goToCart() {
            window.location.href = 'cart.php';
        }
    </script>
</head>
<body>

    <h1>カート編集</h1>

    <!-- 商品検索フォーム -->
    <form id="addItemForm">
        <input type="text" id="item_id" name="item_id" placeholder="13桁のJANコードを入力" maxlength="13">
        <button type="submit">追加</button>
    </form>
    <p id="message"></p>
    <p id="error-message"></p>

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

    <button onclick="goToCart()">カートに戻る</button>

</body>
</html>
