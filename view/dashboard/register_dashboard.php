<?php 
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>無人レジ管理画面</title>
    <link rel="stylesheet" href="../../asset/css/style/all.css" />
    <link rel="stylesheet" href="../../asset/css/style/header.css" />
    <link rel="stylesheet" href="../../asset/css/style/main.css" />
    <link rel="stylesheet" href="../../asset/css/style/footer.css" />
    <!-- <link rel="stylesheet" href="../../asset/css/component/sidebar.css" />
    <link rel="stylesheet" href="../../asset/css/component/content.css" />
    <link rel="stylesheet" href="../../asset/css/component/container.css">
    <link rel="stylesheet" href="../../asset/css/component/box.css">
    <link rel="stylesheet" href="../../asset/css/component/button.css" />
    <link rel="stylesheet" href="../../asset/css/component/table.css">
    <link rel="stylesheet" href="../../asset/css/component/text.css" /> -->
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
        .register-paused {
            font-size: 32px;
            font-weight: bold;
            color: blue;
            text-align: center;
            padding: 50px;
            background-color: #d3d3d3;
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
<body onload="startClock()">
    <!-- ヘッダー部分 -->
    <div class="header">
      <header class="header_left">
        <!-- <span>ログインユーザー名： </span> -->
      </header>
      <div class="header_right">
        <span id="now"></span>
      </div>
    </div>
    <!-- メイン部分 -->
    <main class="container" id="register-container">
        <!-- レジ情報を非同期で更新 -->
    </main>

    <script>
        $(document).ready(function() {
            updateRegisters();
            setInterval(updateRegisters, 2000); // 2秒ごとに更新
        });
    </script>
    <script src="../../asset/js/updateRegisters.js"></script>
    <script src="../../asset/js/clearNotification.js"></script>
    <script src="../../asset/js/time.js"></script>
</body>
</html>
