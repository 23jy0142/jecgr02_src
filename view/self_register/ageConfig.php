<?php
// require_once '../../dao/auth.php'; // 共通の認証ファイルを読み込む
// require_once '../../dao/cart_functions.php';
// $selfregister_id = $_SESSION['selfregister_id'];
// update_selfregister_status($selfregister_id, "3"); // ステータスを 3 に更新
// $errorMessage = "";
// // セッションから selfregister_id を取得
// if (!isset($_SESSION['selfregister_id'])) {
//   die("❌ セッションエラー: selfregister_id が設定されていません");
// }

// $selfregister_id = $_SESSION['selfregister_id'];
// $pdo = db_connect();

// // 年齢確認が必要かチェック
// $stmt = $pdo->prepare("SELECT age_verification FROM cart_items WHERE selfregister_id = :selfregister_id");
// $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
// $stmt->execute();
// $age_verification = $stmt->fetchColumn();
// print($age_verification);

// // ログインフォーム送信時の処理
// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//   $password = $_POST['password'] ?? '';
//   print("1ログイン成功！");
//   if (authenticateUser($password)) {
//     print("2ログイン成功！");
//       // 年齢確認を完了したことをデータベースに更新
//       $update_stmt = $pdo->prepare("UPDATE cart_items SET age_verification = '1' WHERE selfregister_id = :selfregister_id");
//       $update_stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
      
//       if ($update_stmt->execute()) {
//           // ✅ 更新成功後に適切なページへリダイレクト
//           header("Location: cart.php");
//           exit();
//       } else {
//           die("❌ データベース更新エラー: 年齢確認ステータスの更新に失敗しました");
//       }
//     }

// }

require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';
session_start();

$selfregister_id = $_SESSION['selfregister_id'];
$pdo = db_connect();
update_selfregister_status($selfregister_id, "3"); // ステータスを 3 に更新
// ✅ `age_verification = '2'` の商品を取得
$stmt = $pdo->prepare("SELECT * FROM cart_items WHERE selfregister_id = :selfregister_id AND age_verification = '2'");
$stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
$stmt->execute();
$ageRestrictedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST['password'];
    print($password);
    // ✅ パスワードのハッシュ化
    $hashedPassword = hash('sha256', $password);
    print($hashedPassword);
    // ✅ ログイン処理
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM employee WHERE employee_password = :hashedPassword");
    $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->columnCount();
    print($count);
    if ($count > 0) {
        print("テスト1");
        // ✅ `age_verification` を更新し、cart.php へ遷移
        $updateStmt = $pdo->prepare("UPDATE cart_items SET age_verification = '1' WHERE selfregister_id = :selfregister_id");
        $updateStmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
        $updateStmt->execute();
        header("Location: cart.php");

    //     header("Location: cart.php");
    //     exit();
    // } else {
    //     header("Location: ageConfig.php?error=パスワードが間違っています");
    //     exit();
    }
}
// if ($age_verification === "2") {
//   // 年齢確認を完了したことをデータベースに更新
//   $update_stmt = $pdo->prepare("UPDATE cart_items SET age_verification = '1' WHERE selfregister_id = :selfregister_id");
//   $update_stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
//   if ($update_stmt->execute()) {
//       // ✅ 更新成功後に適切なページへリダイレクト
//       header("Location: cart.php");
//       exit();
//   } else {
//       die("❌ データベース更新エラー: 年齢確認ステータスの更新に失敗しました");
//   }
// } else {
//   // 既に年齢確認済みの場合はカートへリダイレクト
//   // header("Location: cart.php");
//   // exit();
// }

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
            <form action="#" method="post" class="passward_text">
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
            <?php if (!empty($ageRestrictedItems)): ?>
                <?php foreach ($ageRestrictedItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['item_id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">年齢確認が必要な商品はありません。</td>
                </tr>
            <?php endif; ?>
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


