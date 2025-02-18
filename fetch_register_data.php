<?php
require_once 'db_connect.php';
$link1 = null;
school_db_connect($link1);

// レジ情報を取得
$query = "SELECT selfregister_id, selfregister_status FROM self_register";
$result = mysqli_query($link1, $query);

if (!$result) {
    error_log("SQL Error: " . mysqli_error($link1)); // SQLエラーログを出力
    echo json_encode(["success" => false, "error" => mysqli_error($link1)]);
    exit;
}

$registers = [];
while ($row = mysqli_fetch_assoc($result)) {
    $selfregister_id = $row['selfregister_id'];

    // カート情報を取得
    $cart_query = "SELECT item_id, product_name, quantity, price FROM cart_items WHERE selfregister_id = ?";
    $stmt = mysqli_prepare($link1, $cart_query);
    mysqli_stmt_bind_param($stmt, "s", $selfregister_id);
    mysqli_stmt_execute($stmt);
    $cart_result = mysqli_stmt_get_result($stmt);

    if (!$cart_result) {
        error_log("Cart Query Error (selfregister_id: $selfregister_id): " . mysqli_error($link1));
    }

    $total_price = 0;
    $items = [];
    
    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $total_price += floor($cart_row["price"]) * $cart_row["quantity"]; // 小数点以下切り捨て
        $items[] = $cart_row;
    }

    mysqli_stmt_close($stmt);

    // レジ情報にカートデータを追加
    $row['total_price'] = $total_price;
    $row['items'] = $items;
    $registers[] = $row;
}

// レスポンス内容をログ出力
error_log("Fetch Data Response: " . json_encode($registers));

mysqli_close($link1);
echo json_encode(["success" => true, "data" => $registers]);
?>
