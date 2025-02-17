<?php
require_once 'db_connect.php';

// カートアイテム取得
function get_cart_items($selfregister_id) {
    school_db_connect($link);
    $query = "SELECT * FROM cart_items WHERE selfregister_id = '$selfregister_id'";
    $result = mysqli_query($link, $query);
    $items = [];

    while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $items[] = [
            'selfregister_id' => $data['selfregister_id'],
            'cart_id' => $data['cart_id'],
            'item_id' => $data['item_id'],
            'product_name' => $data['product_name'],
            'quantity' => $data['quantity'],
            'price' => intval($data['price']),
            'added_at' => $data['added_at']
        ];
    }
    mysqli_close($link);
    return $items;
}

// カートアイテム削除
function delete_cart_items($selfregister_id) {
    school_db_connect($link);
    $query = "DELETE FROM cart_items WHERE selfregister_id = '$selfregister_id'";
    mysqli_query($link, $query);
    mysqli_close($link);
}
?>
