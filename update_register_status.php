<?php
require_once 'db_connect.php';
$link1 = null;
school_db_connect($link1);

$selfregister_id = $_POST['selfregister_id'];
$status = $_POST['status'];

$query = "UPDATE self_register SET selfregister_status = ? WHERE selfregister_id = ?";
$stmt = mysqli_prepare($link1, $query);
mysqli_stmt_bind_param($stmt, "ss", $status, $selfregister_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($link1);
?>
