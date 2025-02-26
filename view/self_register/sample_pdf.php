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
        item_tax,
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
$method = $_GET['method'] ?? 'cash';
$items = get_trading_data($selfregister_id,$trading_id);

if (!$selfregister_id) {
    die("❌ セッションに selfregister_id がありません");
}

// 変数定義（取得したデータの最初の要素から）
$branch_name   = $items[0]["branchoffice_name"] ?? "店舗名未設定";
$tel           = $items[0]["TEL"] ?? "TEL未設定";
$trading_time  = $items[0]["payment_date"] ?? date("Y-m-d H:i");
$payment_method = ($method === 'credit') ? "クレジットカード支払い" : "現金支払い"; 
// お預かりダミー
// $inputAmount = 10000; 

// 計算
$subtotal = 0;             // 小計
$total_quantity = 0;       // 合計個数
$receipt_row = 110;        // レシートの長さ
$tax_state = 0;            // 小計で行を増やすための値
$totalPrice_8tax = 0;      // 消費税８％の商品の合計計算（税抜き）
$totalPrice_10tax = 0;     // 消費税１０％の商品の合計計算（税抜き）
$totalPrice_8state = 0;       //小計の消費税の行表示用。8%
$totalPrice_10state = 0;       //小計の消費税の行表示用。10%
foreach ($items as $item) {
    $tax = $item["item_tax"];
    $total_quantity += $item["quantity"];
    $subtotal += $item["quantity"] * $item["item_price"];
    if($item["quantity"] > 1){
        $receipt_row += 7;
    }
    if($tax == 0.08){
        $totalPrice_8tax += $item["item_price"] * $item["quantity"];
    }
    if($tax == 0.1){
        $totalPrice_10tax += $item["item_price"] * $item["quantity"];
    }
    if($tax == 0.08 && ($tax_state == 0 || $tax_state == 1 || $tax_state == 2) && $totalPrice_8state == 0){
        $tax_state += 1;
        $receipt_row += 4;
        $totalPrice_8state = 1;
        
    }
    if($tax == 0.1 && ($tax_state == 0 || $tax_state == 1 || $tax_state == 2) && $totalPrice_10state == 0 ){
        $tax_state += 2;
        $receipt_row += 4;
        $totalPrice_10state = 1;
    }
    
}

$consumption_8tax = round($totalPrice_8tax * 0.08);
$consumption_10tax = round($totalPrice_10tax * 0.1);

$total_amount = $subtotal + $tax; 
$total_amount += ($consumption_8tax + $consumption_10tax);// 合計金額
$change = $inputAmount - $total_amount; // お釣り

//レシートの長さ＋現金かクレジットか
$length = 7 * count($items);
if($payment_method === 'クレジットカード支払い'){
    $receipt_row += 70;
}

// TCPDFオブジェクトを作成
$pdf = new TCPDF("P", "mm", array(80, ($receipt_row + $length)), true, "UTF-8", false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5);
$pdf->AddPage();

// フォント設定（日本語フォント）
$pdf->SetFont("kozgopromedium", "", 12);

// ヘッダー（店名・電話番号・日付）
$pdf->Image("../../asset/image/gase2.jpg", 20, 6, 40);
$pdf->Ln(14);
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(0, 5, "TEL: " . $tel, 0, 1, "C");
$pdf->Cell(0, 5, $trading_time, 0, 1, "C");
$pdf->Cell(0, 5, "レシート番号：".($trading_id) . "　　レジ番号：".($selfregister_id), 0, 1, "C");
// $pdf->Cell(0, 5, , 0, 1, "R");

// タイトル
$pdf->SetFont("kozgopromedium", "", 14);
$pdf->Cell(0, 8, "＊～*～*～＊ 領収書 ＊～*～*～＊", 0, 1, "C");
$pdf->Ln(2);

// 商品リスト
$pdf->SetFont("kozgopromedium", "", 10);
foreach ($items as $item) {
    $pdf->Cell(20, 6, mb_substr($item["product_name"], 0, 11), 0, 0);
    $pdf->Cell(30, 6, $item["quantity"] . "個", 0, 0, "R");
    $pdf->Cell(20, 6, number_format($item["quantity"] * $item["item_price"]) . "円", 0, 1, "R");
    if ($item["quantity"] > 1) {
        $pdf->Cell(50, 6, "単" . $item["item_price"] . "円", 0, 1 ,"C");
    }
    
}
$pdf->Ln(2);

$pdf->SetFont("kozgopromedium", "", 14);
$pdf->Cell(0, 8, "＊～*～*～＊ ～＊～ ＊～*～*～＊", 0, 1, "C");

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
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(50, 6, "小計", 0, 0);
$pdf->Cell(20, 6, number_format($subtotal) . "円", 0, 1, "R");
switch($tax_state){
    case 1:
        $pdf->Cell(50, 6, "消費税 (  8%)", 0, 0);
        $pdf->Cell(20, 6, number_format($consumption_8tax) . "円", 0, 1, "R");
        break;
    case 2:
        $pdf->Cell(50, 6, "消費税 (  10%)", 0, 0);
        $pdf->Cell(20, 6, number_format($consumption_10tax) . "円", 0, 1, "R");
        break;
    case 3:
        $pdf->Cell(50, 6, "消費税 (  8%)", 0, 0);
        $pdf->Cell(20, 6, number_format($consumption_8tax) . "円", 0, 1, "R");
        $pdf->Cell(50, 6, "消費税 (  10%)", 0, 0);
        $pdf->Cell(20, 6, number_format($consumption_10tax) . "円", 0, 1, "R");
        break;
}

$pdf->SetFont("kozgopromedium", "B", 14);
$pdf->Cell(50, 8, "合計", 0, 0);
$pdf->Cell(20, 8, number_format($total_amount) .  "円", 0, 1, "R");
$pdf->Ln(3);
// お預かり・お釣り
if($method === 'cash'){
    $pdf->SetFont("kozgopromedium", "", 10);
    $pdf->Cell(50, 6, "お預り", 0, 0);
    $pdf->Cell(20, 6, number_format($inputAmount) . "円", 0, 1, "R");
    $pdf->Cell(50, 6, "お釣り", 0, 0);
    $pdf->Cell(20, 6, number_format($change) . "円", 0, 1, "R");
}else{
    $pdf->SetFont("kozgopromedium", "B", 10);
    $pdf->Cell(50, 6, "支払い方法", 0, 0);
    $pdf->Cell(20, 8, $payment_method, 0, 1, "R");
    $pdf->SetFont("kozgopromedium", "", 10);
    $pdf->Cell(50, 6, "お預り", 0, 0);
    $pdf->Cell(20, 6, number_format($total_amount) . "円", 0, 1, "R");
}

$pdf->Ln(5);

// **🔟 クレジットカードご利用票を追加**
if ($method === 'credit') {
    $pdf->SetFont("kozgopromedium", "B", 12);
    $pdf->Cell(0, 8, "[ クレジットカードご利用票 ]", 0, 1, "C");

    $pdf->SetFont("kozgopromedium", "", 10);
    $pdf->Cell(50, 6, "加盟店名:" . $branch_name, 0, 1);
    $pdf->Cell(50, 6, "ご利用日時: " . $trading_time, 0, 1);
    $pdf->Cell(50, 6, "伝票番号:".$trading_id, 0, 1);
    $pdf->Cell(50, 6, "合計金額: " . number_format($total_amount) . "円", 0, 1);
    $pdf->Cell(50, 6, "カード会社: Mastercard", 0, 1);
    $pdf->Cell(50, 6, "カード番号: IC 9999XXXXXX9999", 0, 1);
    $pdf->Cell(50, 6, "支払い方法: 1回払い", 0, 1);
    $pdf->Cell(50, 6, "取引内容: 売上". number_format($total_amount)."円",1,1);
    $pdf->Cell(50, 6, "承認番号: XXXXXX", 0, 1);
    $pdf->Ln(2);
    $pdf->Cell(50, 6, "加盟店控え", 0, 1, "C");
    $pdf->Ln(2);
}

// フッター
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(0, 6, "またのご来店お待ちしております", 0, 1, "C");

// PDFを出力
$pdf->Output("receipt.pdf", "I");
?>
