<?php

// 出力バッファリングを開始し、事前の出力を抑制
ob_start();

// get_trading_data関数でデータを取得
function get_trading_data($selfregister_id,$trading_id) {
    $pdo = db_connect();
//     $query = "
//     SELECT 
//         bo.branchoffice_name, 
//         bo.phone_number AS TEL, 
//         MAX(si.trading_information_id), 
//         si.payment_date, 
//         mi.product_name, 
//         mi.item_price, 
//         si.quantity, 
//         mi.item_price * si.quantity AS '点数金額'
//     FROM master_item AS mi
//     INNER JOIN sales_items AS si ON mi.item_id = si.item_id
//     INNER JOIN branch_office AS bo ON mi.branchoffice_id = bo.branchoffice_id
//     WHERE si.trading_information_id = :trading_information_id
// ";

    $query = "
    SELECT 
        bo.branchoffice_name, 
        bo.phone_number AS TEL, 
        si.trading_information_id,
        si.payment_date, 
        mi.product_name, 
        mi.item_price, 
        si.quantity, 
        mi.item_price * si.quantity AS '点数金額'
    FROM master_item AS mi
    INNER JOIN sales_items AS si ON mi.item_id = si.item_id
    INNER JOIN branch_office AS bo ON mi.branchoffice_id = bo.branchoffice_id
    WHERE si.trading_information_id = :trading_information_id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':trading_information_id', $trading_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



require_once('../../asset/TCPDF-main/tcpdf.php'); // TCPDFライブラリを読み込む
require_once('../../dao/db_connect.php');
require_once('../../dao/cart_functions.php');
// require_once '../../dao/generate_pdf.php'; // php読み込み

session_start();

// セッションから自分の登録IDを取得
$selfregister_id = $_SESSION['selfregister_id'] ?? null;
$inputAmount = $_GET['inputAmount'];
$trading_id = $_GET['trading_information_id'];
$items = get_trading_data($selfregister_id,$trading_id);

if (!$selfregister_id) {
    die("❌ セッションに selfregister_id がありません");
}



// 変数定義（取得したデータの最初の要素から）
$branch_name   = $items[0]["branchoffice_name"] ?? "店舗名未設定";
$tel           = $items[0]["TEL"] ?? "TEL未設定";
$trading_time  = $items[0]["payment_date"] ?? date("Y-m-d H:i");
// お預かりダミー
// $inputAmount = 10000; 

// 計算
$subtotal = 0;
$total_quantity = 0;
foreach ($items as $item) {
    $total_quantity += $item["quantity"];
    $subtotal += $item["quantity"] * $item["item_price"];
}
$tax = round($subtotal * 0.1); // 消費税10%
$total_amount = $subtotal + $tax; // 合計金額
$change = $inputAmount - $total_amount; // お釣り
$length = 7 * count($items);

// TCPDFオブジェクトを作成
$pdf = new TCPDF("P", "mm", array(80, (100 + $length)), true, "UTF-8", false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5);
$pdf->AddPage();

// フォント設定（日本語フォント）
$pdf->SetFont("kozgopromedium", "", 12);

// ヘッダー（店名・電話番号・日付）
$pdf->Image("../../asset\image\gase2.jpg", 20, 6, 40);
$pdf->Ln(14);
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(0, 5, "TEL: " . $tel, 0, 1, "C");
$pdf->Cell(0, 5, $trading_time, 0, 1, "C");
$pdf->Cell(0, 5, "レシート番号：".($trading_id), 0, 1, "R");
$pdf->Cell(0, 5, "レジ番号：".($selfregister_id), 0, 1, "R");

// タイトル
$pdf->SetFont("kozgopromedium", "B", 14);
$pdf->Cell(0, 8, "＊～*～*～＊ 領収書 ＊～*～*～＊", 0, 1, "C");
$pdf->Ln(1);

// 商品リスト
$pdf->SetFont("kozgopromedium", "", 10);
foreach ($items as $item) {
    $pdf->Cell(20, 6, $item["product_name"], 0, 0);
    $pdf->Cell(30, 6, $item["quantity"] . "個", 0, 0, "R");
    $pdf->Cell(20, 6, number_format($item["quantity"] * $item["item_price"]) . "円", 0, 1, "R");
    if ($item["quantity"] > 1) {
        $pdf->Cell(50, 6, "単" . $item["item_price"] . "円", 0, 1);
    }
    
}
$pdf->Ln(5);

// デバッグ用にログ出力
// file_put_contents(__DIR__ . '/debug_pdf_loop.txt', "アイテム数: " . count($items) . "\n");

// foreach ((array)$items as $key => $item) {
//     file_put_contents(__DIR__ . '/debug_pdf_loop.txt', "ループ回数: " . $key . " - 商品名: " . $item["product_name"] . "\n", FILE_APPEND);

//     $pdf->Cell(40, 6, $item["product_name"], 1, 0, "L");
//     $pdf->Cell(15, 6, $item["quantity"] . "個", 1, 0, "C");
//     $pdf->Cell(20, 6, number_format($item["点数金額"]) . "円", 1, 1, "R");
// }
// $pdf->Ln(5);




// 小計・消費税・合計
$pdf->Cell(50, 6, "小計", 0, 0);
$pdf->Cell(20, 6, number_format($subtotal) . "円", 0, 1, "R");

$pdf->Cell(50, 6, "消費税 (10%)", 0, 0);
$pdf->Cell(20, 6, number_format($tax) . "円", 0, 1, "R");

$pdf->SetFont("kozgopromedium", "B", 12);
$pdf->Cell(50, 8, "合計", 0, 0);
$pdf->Cell(20, 8, number_format($total_amount) . "円", 0, 1, "R");

// お預かり・お釣り
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(50, 6, "お預り", 0, 0);
$pdf->Cell(20, 6, number_format($inputAmount) . "円", 0, 1, "R");

$pdf->Cell(50, 6, "お釣り", 0, 0);
$pdf->Cell(20, 6, number_format($change) . "円", 0, 1, "R");

$pdf->Ln(10);

// フッター
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(0, 6, "またのご来店お待ちしております", 0, 1, "C");

// PDFを出力
$pdf->Output("receipt.pdf", "I");
?>
