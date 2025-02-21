<?php
require_once('../asset/TCPDF-main/tcpdf.php'); // TCPDFライブラリを読み込む

$pdo = db_connect();

        // INSERT文を実行
        $stmt = $pdo->prepare("SELECT branchoffice_name, phone_number AS TEL, sales_id, payment_date, product_name, mi.item_price, quantity, mi.item_price*quantity AS '点数金額'
                                      FROM master_item AS mi
                                      INNER JOIN  sales_items AS si ON mi.item_id = si.item_id
                                      INNER JOIN  branch_office AS bo ON mi.branchoffice_id = bo.branchoffice_id
                                      WHERE payment_date = '2025-02-18 21:34:07'");

            foreach ($INSERT_items as $item){
              $stmt->execute([
                  
              ]);
          }





// TCPDFクラスを拡張してカスタムヘッダーとフッターを作成
class CustomPDF extends TCPDF {
    // ヘッダー
    public function Header() {
        $this->SetFont('kozgopromedium', '', 12);
        $this->Cell(0, 10, 'PDFサンプル - ヘッダー', 0, 1, 'C');
        $this->Ln(5); // 余白
    }

    // フッター
    public function Footer() {
        $this->SetY(-15); // ページの下から15mmの位置
        $this->SetFont('kozgopromedium', '', 8);
        $this->Cell(0, 10, 'ページ ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// PDFオブジェクトを作成
$pdf = new CustomPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// ドキュメント情報を設定
$pdf->SetCreator('MyApp');
$pdf->SetAuthor('あなたの名前');
$pdf->SetTitle('サンプルPDF');
$pdf->SetSubject('PHPでPDFを作成');
$pdf->SetKeywords('TCPDF, PDF, PHP, 日本語');

// マージン設定
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);

// **日本語フォントを設定**
$pdf->SetFont('kozgopromedium', '', 12); // 日本語フォントを指定

// ページを追加
$pdf->AddPage();

// **コンテンツ追加（日本語対応）**
$content = "これはPHPで生成されたPDFのサンプルです。\n\n";
$content .= "TCPDFライブラリを使用すると、テキストや画像、表、QRコードなどを簡単に追加できます。\n\n";
$content .= "UTF-8に対応しているので、日本語も正しく表示されます。\n\n";
$content .= "フッターにはページ番号が自動で表示されます。";

$pdf->MultiCell(0, 10, $content, 0, 'L', false, 1);

// **PDFを出力（ブラウザで表示）**
$pdf->Output('sample.pdf', 'I');
