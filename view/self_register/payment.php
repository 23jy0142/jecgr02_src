<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お支払い方法</title>
    <link rel="stylesheet" href="../../asset/css/style/header.css" />
    <link rel="stylesheet" href="../../asset/css/style/main.css" />
    <link rel="stylesheet" href="../../asset/css/style/footer.css" />
    <link rel="stylesheet" href="../../asset/css/component/sidebar.css" />
    <link rel="stylesheet" href="../../asset/css/component/content.css" />
    <link rel="stylesheet" href="../../asset/css/component/container.css">
    <link rel="stylesheet" href="../../asset/css/component/box.css">
    <link rel="stylesheet" href="../../asset/css/component/button.css" />
    <link rel="stylesheet" href="../../asset/css/component/table.css">
    <link rel="stylesheet" href="../../asset/css/component/text.css" />
    <link rel="stylesheet" href="../../asset/css/style/all.css" />
</head>
<body onload="startClock()">
    <div class="header">
        <header class="header_left"></header>
            <div class="header_right">
                <span id="now"></span>
            </div>
        </div>
    <div class="main">
        <h1 id="center_msg">お支払方法の選択</h1>
        <div class="2rows">
        <button class="btn_green2 btn" onclick="location.href='cash_payment.php?method=cash'">現金</button>
        <button class="btn_gray2 btn" onclick="location.href='cash_payment.php?method=credit'">クレジット</button>
        </div>
    </div>
</body>
</html>
