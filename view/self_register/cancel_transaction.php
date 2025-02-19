<?php
session_start();
require_once '../../dao/db_connect.php';
require_once '../../dao/cart_functions.php';

// セッションから selfregister_id を取得
if (!isset($_SESSION['selfregister_id'])) {
    die("エラー: レジIDが設定されていません");
}
$selfregister_id = $_SESSION['selfregister_id'];
update_selfregister_status($selfregister_id, "6"); // ステータスを 6 に更新
header("Location: index.php");
?>_