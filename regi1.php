<?php
$selfregister_id = 101;  // レジを増やした時に変更する箇所

// DB接続関数
function school_db_connect(&$link1) {
    $link1 = mysqli_connect('10.64.144.5', '23jya02', '23jya02', '23jya02');
    if (!mysqli_set_charset($link1, "utf8")) {
        printf("Error loading character set utf8: %s\n", mysqli_error($link1));
        exit();
    }
    if (mysqli_connect_errno()) {
        die("データベースに接続できません:" . mysqli_connect_error() . "\n");
    }
}

// カートアイテムの取得（$selfregister_idでフィルタリング）
function get_cart_items($link, $selfregister_id) {
    $query = "SELECT * FROM cart_items WHERE selfregister_id = '$selfregister_id'";
    $result = mysqli_query($link, $query);
    $items = [];

    while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $items[] = [
            'selfregister_id' => $data['selfregister_id'],
            'cart_id' => $data['cart_id'],
            'item_id' => $data['item_id'],
            'product_name' => $data['product_name'],
            'quantity' => $data['quantity'],
            'price' => intval($data['price']),
            'added_at' => $data['added_at']
        ];
    }

    return $items;
}

// カートアイテム削除
function delete_cart_items($link, $selfregister_id) {
    $query = "DELETE FROM cart_items2 WHERE selfregister_id = '$selfregister_id'";
    mysqli_query($link, $query);
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }

        #welcome-screen, #cart-section, #payment-section, #complete-section {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        button {
            font-size: 14px;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
        }

        button.large {
            font-size: 18px;
            padding: 14px 28px;
        }

        input {
            font-size: 14px;
            padding: 5px;
            margin-top: 5px;
            width: 200px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#welcome-screen').show(); // 最初は「いらっしゃいませ」画面を表示

            $('#start-button').click(function() {
                $('#welcome-screen').hide();
                $('#cart-section').show();
                updateCartItems();
            });

            $('#payment-button').click(function() {
                $('#cart-section').hide();
                $('#payment-section').show();
            });

            $('#cash-button').click(function() {
                $('#payment-section').hide();
                $('#cash-payment').show();
                calculateAmounts();
            });

            $('#input-amount').on('input', function() {
                calculateAmounts();
            });

            $('#complete-payment').click(function() {
                var change = parseInt($('#change').val());
                var message = 'ご利用ありがとうございます';

                // カートアイテム削除
                $.ajax({
                    url: './delete_cart_items.php',
                    type: 'POST',
                    data: { selfregister_id: 101 },  // レジを増やした時に変更する箇所
                    success: function(response) {
                        console.log(response);
                    }
                });

                if (change > 0) {
                    message += '\nおつり ' + change + ' 円\nおつりの取り忘れにご注意ください';
                }

                $('#cash-payment').hide();
                $('#complete-section').show();
                $('#complete-message').text(message);

                // 3秒後に「いらっしゃいませ」画面に戻る
                setTimeout(function() {
                    $('#complete-section').hide();
                    $('#welcome-screen').show();
                }, 3000);
            });

            $('.back-button').click(function() {
                $('#complete-section').hide();
                $('#welcome-screen').show();
            });

            // 定期的にデータを更新（2秒ごとに）
            setInterval(function() {
                updateCartItems();
            }, 2000);

            function updateCartItems() {
                $.ajax({
                    url: './get_cart_items1.php',    // レジを増やした時に変更する箇所
                    type: 'GET',
                    data: { selfregister_id: 101 },  // レジを増やした時に変更する箇所
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            let tableContent = '';
                            $.each(response.data, function(index, item) {
                                tableContent += `<tr>
                                                    <td>${item.item_id}</td>
                                                    <td>${item.product_name}</td>
                                                    <td>${item.quantity}</td>
                                                    <td>${item.price} 円</td>
                                                </tr>`;
                            });
                            $('#cart-items tbody').html(tableContent);
                        } else {
                            alert('データの取得に失敗しました');
                        }
                    }
                });
            }

            function calculateAmounts() {
                var totalAmount = 0;
                $('#cart-items tbody tr').each(function() {
                    var price = $(this).find('td').eq(3).text().replace(' 円', '');
                    var quantity = $(this).find('td').eq(2).text();
                    totalAmount += parseInt(price) * parseInt(quantity);
                });

                var inputAmount = parseInt($('#input-amount').val()) || 0;
                var shortage = totalAmount - inputAmount;
                var change = inputAmount - totalAmount;

                $('#total-amount').text(totalAmount + ' 円');
                $('#shortage').text(shortage > 0 ? shortage + ' 円' : '0 円');
                $('#change').val(change > 0 ? change : '0');

                $('#complete-payment').prop('disabled', inputAmount < totalAmount);
            }
        });
    </script>
</head>
<body>

    <!-- いらっしゃいませ画面 -->
    <div id="welcome-screen">
        <h1>いらっしゃいませ</h1>
        <button id="start-button" class="large">開始</button>
    </div>

    <!-- カート情報画面 -->
    <div id="cart-section">
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
        <button id="payment-button" class="large">お支払いへ</button>
    </div>

    <!-- 支払い方法選択画面 -->
    <div id="payment-section">
        <h1>お支払い方法の選択</h1>
        <button id="cash-button" class="large">現金</button>
        <button id="credit-button" class="large">クレジット</button>
    </div>

    <!-- 現金支払い画面 -->
    <div id="cash-payment" style="display:none;">
        <h2>現金でのお支払い</h2>
        <div>合計金額: <span id="total-amount">0 円</span></div>
        <div>投入金額: <input type="number" id="input-amount" placeholder="投入金額" value="0"></div>
        <div>不足金額: <span id="shortage">0 円</span></div>
        <div>おつり: <input type="text" id="change" disabled="true"></div>
        <button id="complete-payment" disabled="true" class="large">お支払い完了</button>
        <button class="back-button large">戻る</button>
    </div>

    <!-- 支払い完了画面 -->
    <div id="complete-section">
        <h1>お支払い完了</h1>
        <p id="complete-message"></p>
        <button class="back-button large">戻る</button>
    </div>

</body>
</html>
