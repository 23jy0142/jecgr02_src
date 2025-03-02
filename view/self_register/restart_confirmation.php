<?php
require_once '../../dao/auth.php'; // 共通の認証ファイルを読み込む

// ログインフォーム送信時の処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'] ?? '';

    if (authenticateUser($password)) {
        header("Location: reopen.php"); // ログイン成功時
        exit();
    } else {
        $_SESSION['error'] = "パスワードが間違っています";
        header("Location: restart_confirmation.php"); // ログイン失敗時
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
    <title>再開確認パスワード</title>
</head>
</style>

<body onload="startClock()">
<div class="header">
      <header class="header_left">
        
      </header>
      <div class="header_right">
        <span id="now"></span>
      </div>
    </div>
    <div class="main">
        <div class="container">
            <h1 id = "center_msg">再開確認パスワード</h1>
            <form action="" method="post" class="passward_text">
                <input type="password" name="password" required />
                <input type="submit" value="確定" class="btn" />
            </form>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error" style="color:#e52a17;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <div class="footer"></div>
            <script type="module" src="../../asset/js/time.js"></script>
        </div>
    </div>
    <script src="../../asset/js/time.js"></script>
</body>
</html>