<?php
require_once('asset/TCPDF-main/tcpdf.php'); // TCPDFライブラリを読み込む

// 変数定義（ダミーデータ）
$phone_number = "000-0000-000";
$trading_time = "2025年2月20日 木曜日 20:56";
$items = [
    ["name" => "ポテトチップス", "quantity" => 1, "price" => 130],
    ["name" => "コアラのマーチ", "quantity" => 2, "price" => 150],
    ["name" => "スーパードライ", "quantity" => 1, "price" => 185]
];
$inputAmount = 1000; // お預かり金額

// 計算
$subtotal = 0;
$total_quantity = 0;
foreach ($items as $item) {
    $subtotal += $item["quantity"] * $item["price"];
    $total_quantity += $item["quantity"];
}
$tax = round($subtotal * 0.1); // 消費税10%
$total_amount = $subtotal + $tax; // 合計金額
$change = $inputAmount - $total_amount; // お釣り
$length = 7*count($items);

// TCPDFオブジェクトを作成
$pdf = new TCPDF("P", "mm", array(80, (100+$length)), true, "UTF-8", false);
$pdf->SetMargins(5, 5, 5);
$pdf->SetAutoPageBreak(true, 5);
$pdf->AddPage();

// フォント設定（日本語フォント）
$pdf->SetFont("kozgopromedium", "", 12);

// ヘッダー（店名・電話番号・日付）
$pdf->Image("asset\image\gase2.jpg", 20, 6, 40);
$pdf->Ln(14);
$pdf->SetFont("kozgopromedium", "", 10);
$pdf->Cell(0, 5, "TEL: " . $phone_number, 0, 1, "C");
$pdf->Cell(0, 5, $trading_time, 0, 1, "C");
// $pdf->Ln(1); // 余白

// タイトル
$pdf->SetFont("kozgopromedium", "B", 14);
$pdf->Cell(0, 8, "＊～*～*～＊ 領収書 ＊～*～*～＊", 0, 1, "C");
$pdf->Ln(1);

// 商品リスト
$pdf->SetFont("kozgopromedium", "", 10);
foreach ($items as $item) {
    $pdf->Cell(20, 6, $item["name"], 0, 0);
    $pdf->Cell(30, 6, $item["quantity"] . "個", 0, 0, "R");
    $pdf->Cell(20, 6, number_format($item["quantity"] * $item["price"]) . "円", 0, 1, "R");
    if($item["quantity"] > 1){
        $pdf->Cell(50, 6, "単" . $item["price"] . "円", 0, 1);
    }
}
$pdf->Ln(5);

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
