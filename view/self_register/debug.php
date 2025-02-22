<?php
require_once '../../dao/db_connect.php';

$trading_information_id = $_GET['trading_information_id'] ?? null;

$pdo = db_connect();
$stmt = $pdo->prepare("
    SELECT 
        bo.branchoffice_name, 
        bo.phone_number AS TEL, 
        si.trading_information_id, 
        si.payment_date, 
        mi.product_name, 
        mi.item_price, 
        si.quantity, 
        mi.item_price * si.quantity AS '点数金額'
    FROM sales_items AS si
    INNER JOIN master_item AS mi ON si.item_id = mi.item_id
    INNER JOIN branch_office AS bo ON mi.branchoffice_id = bo.branchoffice_id
    WHERE si.trading_information_id = :trading_information_id
");
$stmt->bindParam(":trading_information_id", $trading_information_id, PDO::PARAM_INT);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 結果を画面に表示
echo "<pre>";
print_r($items);
echo "</pre>";
