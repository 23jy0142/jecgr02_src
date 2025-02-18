<?php
require_once 'db_connect.php';


/**
 * 管理者ログイン処理
 * @param string $employee_number 社員番号
 * @param string $password パスワード
 * @return bool ログイン成功なら true, 失敗なら false
 */
function login($employee_number, $password) {
    $pdo = db_connect();

    try {
        // パスワードのハッシュ化
        $hashedPassword = hash('sha256', $password);

        // SQLクエリの準備
        $stmt = $pdo->prepare("SELECT * FROM employee WHERE employee_number = :employee_number AND employee_password = :hashedPassword");
        $stmt->bindParam(':employee_number', $employee_number, PDO::PARAM_INT);
        $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
        $stmt->execute();
        $count = intval($stmt->fetchColumn());

        if ($count > 0) {
            $_SESSION['employee_number'] = $employee_number; // セッションに社員番号を保存
            header("Location: register_dashboard.php");
            exit();
        } else {
            header("Location: dashboard_login.php?error=社員番号またはパスワードが間違っています");
            exit();
        }
    } catch (PDOException $e) {
        die("データベースエラー: " . $e->getMessage());
    }
}

/**
 * ログアウト処理
 */
function logout() {
    session_start();
    session_destroy();
    header("Location: dashboard_login.php");
    exit();
}

/**
 * ログイン状態チェック
 * @return bool ログインしているかどうか
 */
function is_logged_in() {
    return isset($_SESSION['employee_number']);
}
?>
