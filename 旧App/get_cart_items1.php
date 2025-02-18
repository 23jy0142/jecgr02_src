<?php
$selfregister_id = 101; // レジを増やした時に変更する箇所

// DB接続関数
function school_db_connect(&$link1) {
    $link1 = mysqli_connect('10.64.144.5', '23jya02', '23jya02', '23jya02');
    if (!mysqli_set_charset($link1, "utf8")) {
        printf("Error loading character set utf8: %s\n", mysqli_error($link1));
        exit();
    }
    if (mysqli_connect_errno()) {
        die("データベースに接続できません:" . mysqli_connect_error() . "\n");
    }
}

// カートアイテムの取得
function get_cart_items($link,$selfregister_id) {
    $query = "SELECT * FROM cart_items where selfregister_id = '$selfregister_id'"; // cart_items2テーブルからデータを取得
    $result = mysqli_query($link, $query);
    $items = [];

    while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $items[] = [
            'selfregister_id' => $data['selfregister_id'],
            'cart_id' => $data['cart_id'],
            'item_id' => $data['item_id'],
            'product_name' => $data['product_name'],
            'quantity' => $data['quantity'],
            'price' => intval($data['price']), // 金額を整数に変換
            'added_at' => $data['added_at']
        ];
    }

    return $items;
}

header('Content-Type: application/json');
$link1 = null;
school_db_connect($link1);
$cart_items = get_cart_items($link1,$selfregister_id);

echo json_encode([
    'success' => true,
    'data' => $cart_items
]);
