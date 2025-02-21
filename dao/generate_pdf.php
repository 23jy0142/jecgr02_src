<!-- <?php
// require_once 'db_connect.php';

// //レシートに必要なデータをすべて取得
// // $pdo = db_connect();
// function get_trading_data($selfregister_id){
//     school_db_connect($link);
//     $query = "SELECT branchoffice_name, phone_number AS TEL, trading_information_id, payment_date, product_name, mi.item_price, quantity, mi.item_price*quantity AS '点数金額'
//                            FROM master_item AS mi
//                            INNER JOIN  sales_items AS si ON mi.item_id = si.item_id
//                            INNER JOIN  branch_office AS bo ON mi.branchoffice_id = bo.branchoffice_id
//                            WHERE trading_inromation_id = :trading_information_id";
//     $result = mysqli_query($link, $query);
//     $trading_data = [];
//     while ($data = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
//         $trading_data[] = [
//             'branchoffice_name' => $data['branchoffice_name'],
//             'TEL' => $data['TEL'],
//             'trading_information_id' => $data['trading_information_id'],
//             'payment_date' => $data['payment_date'],
//             'product_name' => $data['product_name'],
//             'mi.item_price' => intval($data['mi.item_price']),
//             'quentity' => intval($data['quentity']),
//             '点数金額' => intval($data['点数金額']),
//         ];
//     }
//     mysqli_close($link);
//     return $trading_data;
// } 
?> -->