<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = '10.64.144.5';
    $dbname = '23jya02';
    $username = '23jya02';
    $password = '23jya02';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch (PDOException $e) {
        die("データベース接続エラー: " . $e->getMessage());
    }

    $hashedPassword = hash('sha256', $_POST['password']);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM employee WHERE employee_password = :hashedPassword");
    $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
    $stmt->execute();
    $count = intval($stmt->fetchColumn());

    if ($count > 0) {
        header("Location: cart.php");
        exit();
    } else {
        header("Location: ageConfig.php?error=パスワードが間違っています");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>年齢確認</title>
</head>
<style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px;}
    h1 { color: #69be86; }
    .btn { background-color: #9cf;}
</style>

<body>
    <h1>年齢確認が必要です</h1>
    <form action="" method="post">
        <input type="password" name="password" required />
        <input type="submit" value="確定" class="btn" />
    </form>
    <?php if (isset($_GET['error'])): ?>
        <p class="error" style="color:#e52a17;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
</body>
</html>