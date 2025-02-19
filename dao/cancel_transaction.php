<?php 
require_once 'cart_functions.php';
require_once 'db_connect.php';
require_once 'add_sales_items.php';

session_start();
$selfregister_id = $_SESSION['selfregister_id'] ?? null;

if (!$selfregister_id) {
    die("❌ セッションに selfregister_id がありません");
}
// カート内の商品を削除
delete_cart_items($selfregister_id);
?>