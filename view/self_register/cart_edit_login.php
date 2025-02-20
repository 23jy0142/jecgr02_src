<?php
require_once '../../dao/auth.php'; // 共通の認証ファイルを読み込む
require_once '../../dao/cart_functions.php';
update_selfregister_status($_SESSION['selfregister_id'], "3"); // ステータスを 3 に更新
// ログインフォーム送信時の処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'] ?? '';

    if (authenticateUser($password)) {
        header("Location: cart_edit.php"); // ログイン成功時
        exit();
    } else {
        $_SESSION['login_error'] = "パスワードが間違っています";
        header("Location: cart_edit_login.php"); // ログイン失敗時
        exit();
    }
}
?>


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
    <title>カート編集ログイン</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h2 { color: #333; }
    .btn { background-color: #9cf;}
</style>

<body  onload="startClock()">
    <!-- ヘッダー部分 -->
    <div class="header">
      <header class="header_left">
        
      </header>
      <div class="header_right">
        <span id="now"></span>
      </div>
    </div>
    <div class="main">
        <div class="container">
            <div class="login-container">
                <h1 id = "login_msg">ログイン</h1>
                <div class="passward_text">
                    <!-- エラーメッセージの表示 -->
                    <?php if (!empty($_SESSION['login_error'])): ?>
                        <p class="error-message" style="color:#e52a17;"><?= htmlspecialchars($_SESSION['login_error']) ?></p>
                        <?php unset($_SESSION['login_error']); ?>
                    <?php endif; ?>
                    <form method="post">
                        <input type="password" class="passward_text" name="password" placeholder="パスワード" required>
                        <button type="submit" class="btn_blue">ログイン</button>
                    </form>
                </div>
                <div class="content">
                </div>
            </div>
        </div>
    </div>
    <!-- フッター部分 -->
    <div class="footer">
      <div class="container">
        
      </div>
    </div>
    <script type="module" src="../../asset/js/time.js"></script>
</body>
</html>