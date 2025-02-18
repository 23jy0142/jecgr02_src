<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>店員呼び出し</title>
</head>
<style>
    /* body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
    h1 { color: #256aff; }
    button { background-color: #9cf;} */
</style>

<body onload="startClock()">
    <!-- ヘッダー部分 -->
    <div class="header">
      <header class="header_left">
        
      </header>
      <div class="header_right">
        <span id="now"></span>
      </div>
    </div>
    <!-- メイン部分 -->
    <div class="main">
        <h1 id = "center_msg">定員が参ります</h1><br>
        <h1 id = "center_msg">少々お待ちください。</h1>

        <div class="saikai_box">
          <button class="btn btn_blue" onclick="history.back()">承認</button>
        </div>
    </div>
</body>
</html>