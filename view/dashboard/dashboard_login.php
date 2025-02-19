<?php
require_once '../../dao/auth_dashboard.php';

session_start();

// ログイン処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['employee_number'] ?? '';
    $password = $_POST['password'] ?? '';

    if (login($username, $password) > 0) {
        header("Location: register_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "社員番号またはパスワードが間違っています";
        header("Location: dashboard_login.php"); // ログイン失敗時
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/style/all.css" />
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
    <title>管理端末ログイン</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h1 { color: #333; }
    .btn { background-color: #9cf;}
</style>

<body>
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
            <h1 id = "center_msg">ログイン</h1>
            <form action="" method="post">
                <label for="employee_number"><span id="passward_text">社員番号:</span></label><br>
                <input type="text" name="employee_number" required /><br>
                <label for="password"><span id="passaward_text">パスワード:</span></label><br>
                <input type="password" name="password" required /><br>
                <input type="submit" value="確定" class="btn" />
            </form>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error" style="color:#e52a17;"><?php echo htmlspecialchars($_SESSION['error']); ?></p>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            <div class="content">
            
            </div>
        </div>
    </div>
    <!-- フッター部分 -->
    <div class="footer">
      <div class="container">
        
      </div>
    </div>
</body>
</html>