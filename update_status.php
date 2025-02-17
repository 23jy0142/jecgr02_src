<?php
require_once 'cart_functions.php';

$selfregister_id = "101"; // 固定レジID
$status = isset($_POST['status']) ? $_POST['status'] : "0";

if (update_selfregister_status($selfregister_id, $status)) {
    echo "success";
} else {
    echo "error";
}
?>
