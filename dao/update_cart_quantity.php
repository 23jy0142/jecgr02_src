<?php
require_once 'db_connect.php';

$selfregister_id = isset($_POST['selfregister_id']) ? $_POST['selfregister_id'] : "";
$item_id = isset($_POST['item_id']) ? $_POST['item_id'] : "";
$change = isset($_POST['change']) ? intval($_POST['change']) : 0;

if (!$selfregister_id || !$item_id || $change === 0) {
    echo "error";
    exit();
}

$link1 = null;
school_db_connect($link1);

if ($link1) {
    // 現在の個数を取得
    $query = "SELECT quantity FROM cart_items WHERE selfregister_id = ? AND item_id = ?";
    $stmt = mysqli_prepare($link1, $query);
    mysqli_stmt_bind_param($stmt, "ss", $selfregister_id, $item_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $current_quantity = $row ? intval($row["quantity"]) : 0;

    if ($current_quantity > 0) {
        $new_quantity = $current_quantity + $change;

        if ($new_quantity > 0) {
            // 更新処理
            $update_query = "UPDATE cart_items SET quantity = ? WHERE selfregister_id = ? AND item_id = ?";
            $update_stmt = mysqli_prepare($link1, $update_query);
            mysqli_stmt_bind_param($update_stmt, "iss", $new_quantity, $selfregister_id, $item_id);
            $result = mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
        } else {
            // 削除処理
            $delete_query = "DELETE FROM cart_items WHERE selfregister_id = ? AND item_id = ?";
            $delete_stmt = mysqli_prepare($link1, $delete_query);
            mysqli_stmt_bind_param($delete_stmt, "ss", $selfregister_id, $item_id);
            $result = mysqli_stmt_execute($delete_stmt);
            mysqli_stmt_close($delete_stmt);
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link1);
    echo "success";
} else {
    echo "error";
}
?>
