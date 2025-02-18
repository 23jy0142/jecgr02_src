<?php
require_once 'db_connect.php';

/**
 * selfregister_status を更新する関数
 *
 * @param string $selfregister_id
 * @param string $status
 * @return bool 成功なら true, 失敗なら false
 */
function update_selfregister_status($selfregister_id, $status) {
    $link1 = null;
    school_db_connect($link1);

    if ($link1) {
        $query = "UPDATE self_register SET selfregister_status = ? WHERE selfregister_id = ?";
        $stmt = mysqli_prepare($link1, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $status, $selfregister_id);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            $result = false;
        }

        mysqli_close($link1);
        return $result;
    }
    return false;
}


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

/**
 * カートにアイテムを追加する
 */
function addCartItem($selfregister_id, $item_id, $quantity) {
    $pdo = db_connect();
    $stmt = $pdo->prepare("INSERT INTO cart_items (selfregister_id, item_id, quantity) VALUES (:selfregister_id, :item_id, :quantity)
        ON DUPLICATE KEY UPDATE quantity = quantity + :quantity");
    $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * カート内の商品の数量を更新する
 */
function updateCartQuantity($selfregister_id, $item_id, $quantity) {
    $pdo = db_connect();
    $stmt = $pdo->prepare("UPDATE cart_items SET quantity = :quantity WHERE selfregister_id = :selfregister_id AND item_id = :item_id");
    $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    return $stmt->execute();
}

/**
 * カート内のアイテムを削除する
 */
function removeCartItem($selfregister_id, $item_id) {
    $pdo = db_connect();
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE selfregister_id = :selfregister_id AND item_id = :item_id");
    $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_STR);
    return $stmt->execute();
}

/**
 * カートの合計金額を取得する
 */
function getCartTotal($selfregister_id) {
    $pdo = db_connect();
    $stmt = $pdo->prepare("SELECT SUM(price * quantity) AS total FROM cart_items WHERE selfregister_id = :selfregister_id");
    $stmt->bindParam(':selfregister_id', $selfregister_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

// カートアイテム削除
function delete_cart_items($selfregister_id) {
    school_db_connect($link);
    $query = "DELETE FROM cart_items WHERE selfregister_id = '$selfregister_id'";
    mysqli_query($link, $query);
    mysqli_close($link);
}
?>
