<?php
session_start();
require_once 'db_connect.php'; // DB接続を外部ファイル化

/**
 * ユーザー認証処理
 * @param string $password
 * @return bool
 */
function authenticateUser($password) {
    try {
        $pdo = db_connect(); // DB接続

        $hashedPassword = hash('sha256', $password);
        $stmt = $pdo->prepare("SELECT employee_number FROM employee WHERE employee_password = :hashedPassword");
        $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['employee_number'] = $user['employee_number'];
            return true;
        }
        return false;
    } catch (PDOException $e) {
        die("データベースエラー: " . $e->getMessage());
    }
}

/**
 * ログイン状態を確認
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * ログアウト処理
 */
function logout() {
    session_destroy();
    header("Location: cart_edit_login.php");
    exit();
}
