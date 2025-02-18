<?php
require_once 'db_connect.php';
require_once 'cart_functions.php';

header('Content-Type: application/json');

$selfregister_id = isset($_GET['selfregister_id']) ? intval($_GET['selfregister_id']) : 101;

$link1 = null;
school_db_connect($link1);

if ($link1) {
    $query = "SELECT item_id, product_name, quantity, price FROM cart_items WHERE selfregister_id = ?";
    $stmt = mysqli_prepare($link1, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $selfregister_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $cart_items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($link1);

        echo json_encode(["success" => true, "data" => $cart_items]);
    } else {
        echo json_encode(["success" => false, "message" => "SQL 準備に失敗しました"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "データベース接続に失敗しました"]);
}
?>