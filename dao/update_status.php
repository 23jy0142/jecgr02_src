<?php
require_once 'cart_functions.php';

$selfregister_id = $_SESSION["selfregister_id"]; // 固定レジID
$status = isset($_POST['status']) ? $_POST['status'] : "0";

if ($status === null) {
    echo "エラー: ステータスが指定されていません";
    exit;
}


if (update_selfregister_status($selfregister_id, $status)) {
    echo "success";
} else {
    echo "error";
}
?>
