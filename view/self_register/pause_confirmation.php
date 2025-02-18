<?php
require_once '../../dao/auth.php'; // 共通の認証ファイルを読み込む

// ログインフォーム送信時の処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'] ?? '';

    if (authenticateUser($password)) {
        header("Location: pause.php"); // ログイン成功時
        exit();
    } else {
        $_SESSION['login_error'] = "パスワードが間違っています";
        header("Location: pause_confirmation.php"); // ログイン失敗時
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scasle=1.0">
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
    <title>休止確認パスワード</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h1 { color: #333; }
    .btn { background-color: #9cf;}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    <div class="container">
        <h1 id = "center_msg">休止確認パスワード</h1>
        <form action="" method="post" class="passward_text">
            <input type="password" name="password" required />
            <input type="submit" value="確定" class="btn" onclick="pauseRegister()"/>
        </form>
        <?php if (isset($_GET['error'])): ?>
            <p class="error" style="color:#e52a17;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </div>
    <!-- フッター部分 -->
    <div class="footer">
      <div class="container">
        
      </div>
    </div>
</div>
<script type="module" src="../../asset/js/pauseRegister.js"></script>
</body>
</html>