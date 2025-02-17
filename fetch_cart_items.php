<?php
require_once 'cart_functions.php';
header('Content-Type: application/json');

$selfregister_id = isset($_GET['selfregister_id']) ? intval($_GET['selfregister_id']) : 101;

try {
    $cart_items = get_cart_items($selfregister_id);
    echo json_encode(["success" => true, "data" => $cart_items]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
