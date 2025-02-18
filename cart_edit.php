<!-- 商品追加 -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート画面</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .content {
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 24px;
        }

        /* 商品ID入力フォーム */
        form {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* カートアイテムテーブル */
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart-table th, .cart-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .cart-table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .cart-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .cart-table tbody tr:hover {
            background-color: #e9ecef;
        }

        /* 数量ボタン */
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .quantity-btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 5px;
        }

        .decrease {
            background-color: #cce5ff;
            color: #004085;
        }

        .increase {
            background-color: #ffb3b3;
            color: #721c24;
        }

        .decrease:hover {
            background-color: #99c2ff;
        }

        .increase:hover {
            background-color: #ff6666;
        }

        /* 合計金額 */
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            text-align: right;
        }

        /* 編集完了ボタン */
        .edit-done {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .edit-done:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<main class="container">
    <div class="content">
        <h2>商品ID</h2>

        <!-- 商品追加フォーム -->
        <form>
            <input type="text" placeholder="入力してください">
            <button type="submit">追加</button>
        </form>

        <!-- カート一覧 -->
        <table class="cart-table">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>数量</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>商品 1</td>
                    <td>100円</td>
                    <td class="quantity-control">
                        <button class="quantity-btn decrease">−</button>
                        <span>1</span>
                        <button class="quantity-btn increase">+</button>
                    </td>
                </tr>
                <tr>
                    <td>商品 2</td>
                    <td>61円</td>
                    <td class="quantity-control">
                        <button class="quantity-btn decrease">−</button>
                        <span>1</span>
                        <button class="quantity-btn increase">+</button>
                    </td>
                </tr>
                <tr>
                    <td>商品 3</td>
                    <td>6円</td>
                    <td class="quantity-control">
                        <button class="quantity-btn decrease">−</button>
                        <span>1</span>
                        <button class="quantity-btn increase">+</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- 合計金額 -->
        <p class="total">合計: 167円</p>

        <!-- 編集完了ボタン -->
        <button class="edit-done">編集完了</button>
    </div>
</main>

</body>
</html>
