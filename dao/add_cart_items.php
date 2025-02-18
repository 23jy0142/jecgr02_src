<?php
require_once 'db_connect.php';

header('Content-Type: application/json');

// PHP のエラーメッセージを JSON にする
ini_set('display_errors', 1);
error_reporting(E_ALL);

$selfregister_id = isset($_POST['selfregister_id']) ? $_POST['selfregister_id'] : "";
$item_id = isset($_POST['item_id']) ? $_POST['item_id'] : "";

$response = ["status" => "error"];

if (!$selfregister_id || !$item_id || !preg_match('/^\d{13}$/', $item_id)) {
    $response["message"] = "JANコードは13桁の数字のみ入力してください。";
    echo json_encode($response);
    exit();
}

$link1 = null;
school_db_connect($link1);

if (!$link1) {
    $response["message"] = "データベース接続に失敗しました。";
    echo json_encode($response);
    exit();
}

// **修正点: master_items テーブルの `item_price` を正しく取得**
$query = "SELECT product_name, item_price FROM master_item WHERE item_id = ?";
$stmt = mysqli_prepare($link1, $query);

if (!$stmt) {
    $response["message"] = "商品検索のクエリ準備に失敗しました: " . mysqli_error($link1);
    echo json_encode($response);
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $item_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$item = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// **デバッグ情報**
$response["debug"] = [
    "selfregister_id" => $selfregister_id,
    "item_id" => $item_id,
    "sql_query" => $query,
    "sql_error" => mysqli_error($link1),
    "sql_result" => $item ? json_encode($item) : "Not Found"
];

// **商品が見つからなかった場合**
if (!$item) {
    $response["status"] = "not_found";
    $response["message"] = "該当商品が見つかりませんでした。";
    echo json_encode($response);
    exit();
}

// **修正点: `item_price` を `price` に変換**
$item_price = $item["item_price"];

// **カートに商品を追加 or 個数を+1**
$query = "INSERT INTO cart_items (selfregister_id, cart_id, item_id, product_name, quantity, price, added_at)
          VALUES (?, 'C01', ?, ?, 1, ?, NOW())
          ON DUPLICATE KEY UPDATE quantity = quantity + 1";

$stmt = mysqli_prepare($link1, $query);
if (!$stmt) {
    $response["message"] = "カート更新のクエリ準備に失敗しました: " . mysqli_error($link1);
    echo json_encode($response);
    exit();
}

mysqli_stmt_bind_param($stmt, "sssi", $selfregister_id, $item_id, $item["product_name"], $item_price);
$execute_result = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($link1);

if (!$execute_result) {
    $response["message"] = "カート更新に失敗しました。";
    echo json_encode($response);
    exit();
}

$response["status"] = "success";
$response["message"] = "商品がカートに追加されました。";
echo json_encode($response);
?>
