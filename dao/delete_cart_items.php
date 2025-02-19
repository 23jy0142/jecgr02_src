<?php
require_once 'db_connect.php';
require_once 'cart_functions.php';

session_start();

if (!isset($_POST['selfregister_id'])) {
    echo "error: missing_selfregister_id";
    exit();
}

$selfregister_id = $_POST['selfregister_id'];

if (delete_cart_items($selfregister_id)) {
    echo "success";
} else {
    echo "error";
}
?>
