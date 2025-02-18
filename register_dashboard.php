<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>無人レジ管理画面</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            position: relative;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            max-width: 1200px;
            margin: auto;
        }

        .register-box {
            background: #c0c0c0;
            border-radius: 8px;
            padding: 10px;
            text-align: left;
            width: 100%;
            height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .register-header {
            background: #a0a0a0;
            color: white;
            font-weight: bold;
            padding: 6px;
            border-radius: 4px;
            font-size: 12px;
            text-align: center;
        }

        .total-amount {
            font-weight: bold;
            font-size: 12px;
            padding: 6px;
            background: #e0e0e0;
            text-align: center;
            border-radius: 4px;
        }

        .register-content {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            overflow-y: auto;
            padding: 6px;
            border-radius: 4px;
            background: #d0f0f0;
            height: 200px;
        }

        .items {
            background: white;
            flex-grow: 1;
            border-radius: 4px;
            padding: 5px;
            font-size: 10px;
            overflow-y: auto;
            max-height: 150px;
            border: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
            font-size: 9px;
        }

        .notification {
            background: #ff4d4d;
            color: white;
            font-size: 12px;
            padding: 10px;
            border-radius: 6px;
            display: none;
            align-items: center;
            justify-content: space-between;
            margin-top: auto;
            text-align: center;
            cursor: pointer;
        }

        .notification.active {
            display: flex;
        }

        .notification button {
            background: white;
            color: #ff4d4d;
            border: none;
            padding: 2px 5px;
            cursor: pointer;
            font-size: 12px;
            border-radius: 4px;
        }

        .inactive {
            background: #a0a0a0;
            color: blue;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
    </style>
</head>
<body>

    <main class="container" id="register-container">
        <!-- レジ情報を非同期で更新 -->
    </main>

    <script>
        function updateRegisters() {
            $.ajax({
                url: 'fetch_register_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log("🚀 AJAX Response:", response); // デバッグログ

                    if (!response.success) {
                        console.error("❌ Fetch Failed:", response.error);
                        return;
                    }

                    $('#register-container').html('');
                    
                    response.data.forEach(register => {
                        console.log(`ℹ️ レジ ${register.selfregister_id} のデータ:`, register);

                        let notificationText = '';
                        let notificationClass = '';

                        if (register.selfregister_status == "3") {
                            notificationText = "⚠️ スタッフ呼び出し";
                            notificationClass = "active";
                        } else if (register.selfregister_status == "4") {
                            notificationText = "✅ お会計完了";
                            notificationClass = "active";
                        } else if (register.selfregister_status == "5") {
                            notificationText = "ℹ️ 休止中";
                            notificationClass = "active";
                        }

                        let registerHTML = `
                            <div class='register-box' id='register-${register.selfregister_id}'>
                                <div class='register-header'>${register.selfregister_id}番レジ</div>
                                <div class='total-amount'>合計金額: ${Math.floor(register.total_price)} 円</div>
                                <div class='register-content'>
                                    <div class='items'>
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
                                                ${register.items.length > 0 ? register.items.map(item => `
                                                    <tr>
                                                        <td>${item.item_id}</td>
                                                        <td>${item.product_name}</td>
                                                        <td>${item.quantity}</td>
                                                        <td>${Math.floor(item.price)} 円</td>
                                                    </tr>
                                                `).join('') : `<tr><td colspan='4'>カートが空です</td></tr>`}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class='notification ${notificationClass}' id='notification-${register.selfregister_id}'>
                                    ${notificationText}
                                    <button onclick='clearNotification(${register.selfregister_id})'>〆</button>
                                </div>
                            </div>
                        `;

                        $('#register-container').append(registerHTML);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("❌ AJAX Error:", status, error);
                }
            });
        }

        function clearNotification(register_id) {
            $.ajax({
                url: 'update_register_status.php',
                type: 'POST',
                data: { selfregister_id: register_id, status: '1' },
                success: function() {
                    updateRegisters(); // 更新して通知を消す
                }
            });
        }

        $(document).ready(function() {
            updateRegisters();
            setInterval(updateRegisters, 2000); // 2秒ごとに更新
        });
    </script>

</body>
</html>
