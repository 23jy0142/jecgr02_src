<?php
require_once '../../dao/auth.php'; // 共通の認証ファイルを読み込む
require_once '../../dao/cart_functions.php';
$selfregister_id = $_SESSION['selfregister_id'];
update_selfregister_status($selfregister_id, "3"); // ステータスを 3 に更新
$errorMessage = "";
// ログイン処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $employee_number = $_POST['employee_number'] ?? "";
  $password = $_POST['password'] ?? "";

  if (authenticateUser($password)) {
      try {
          $pdo = db_connect();

          // 年齢確認商品の `age_Verification` を更新
          $stmt = $pdo->prepare("
              UPDATE cart_items 
              SET age_verification = false
              WHERE selfregister_id = :selfregister_id
          ");
          $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_STR);
          $stmt->execute();

          // カートページへリダイレクト
          header("Location: cart.php");
          exit();
      } catch (PDOException $e) {
          $errorMessage = "エラー: " . $e->getMessage();
      }
  } else {
      $errorMessage = "社員番号またはパスワードが間違っています。";
  }
}

// 年齢確認が必要な商品の取得
try {
  $pdo = db_connect();
  $stmt = $pdo->prepare("
      SELECT item_id, product_name, quantity 
      FROM cart_items 
      WHERE selfregister_id = :selfregister_id AND age_verification = 2
  ");
  $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
  $stmt->execute();
  $ageRestrictedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  $errorMessage = "エラー: " . $e->getMessage();
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
    <title>年齢確認</title>
</head>
<style>
    /* body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h1 { color: #69be86; }
    .btn { background-color: #9cf;} */
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
          <h1 id = "center_msg">年齢確認が必要です</h1>
          <div class="passward_text">
            <form action="cart.php" method="post" class="passward_text">
                <input type="password" name="password"  required placeholder="パスワードを入力して下さい"/>
                <input type="submit" value="確定" class="btn" />
            </form>
            <?php if (isset($_GET['error'])): ?>
                <p class="error" style="color:#e52a17;"><?php echo htmlspecialchars($_GET['error']); ?></p>
            <?php endif; ?>
          </div>
        <div class="content">
        <h1>年齢確認が必要な商品</h1>
    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>商品ID</th>
                <th>商品名</th>
                <th>数量</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ageRestrictedItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['item_id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
      </div>
    </div>
    <!-- フッター部分 -->
    <div class="footer">
      <div class="container">
        
      </div>
    </div>
    <script src="../../asset/js/time.js"></script>
</body>
</html>