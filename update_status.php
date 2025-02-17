<?php
require_once 'db_connect.php';

$selfregister_id = "101"; // 固定レジID
$status = isset($_POST['status']) ? $_POST['status'] : "0";

// DB接続（$link1 に接続オブジェクトを格納）
$link1 = null;
school_db_connect($link1);

// 接続に成功しているか確認
if ($link1) {
    $query = "UPDATE selfregister SET selfregister_status = ? WHERE selfregister_id = ?";
    $stmt = mysqli_prepare($link1, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $status, $selfregister_id);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }

    mysqli_close($link1);
} else {
    $result = false;
}

// 成功なら "success" を返し、失敗なら "error" を返す
echo $result ? "success" : "error";
?>
