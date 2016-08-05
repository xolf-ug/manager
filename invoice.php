<?php include 'bootstrap.php';

session_start();

if(isset($_GET['i'])) $_POST = json_decode(json_encode($io->table('invoice')->document($_GET['i'])), true);

$customer = $io->table('customer')->document($_POST['customer_id']);

$id = count($io->table('invoice')->getAllDocuments());

$name = $customer->person;
if(trim($name) == "") $name = $customer->name;

$fontSize = 11;

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Source','',10);
$pdf->Cell(0,9 ,utf8_decode($_POST['date']),0,0,'R');
$pdf->ln();
$pdf->ln();
$pdf->ln();
$pdf->Write(5 ,utf8_decode('Kundennummer: ' . $customer->id));
$pdf->ln();
$pdf->SetFont('','',$fontSize + 2);
$pdf->Write($fontSize / 2 ,utf8_decode($customer->name));
$pdf->ln();
$pdf->Write($fontSize / 2 ,utf8_decode($customer->street));
$pdf->ln();
$pdf->Write($fontSize / 2 ,utf8_decode($customer->plz . ' ' . $customer->city));
$pdf->ln();
$pdf->ln();
$pdf->ln();
$pdf->SetFont('','',$fontSize * 2);
$pdf->Write($fontSize , utf8_decode('Rechnung #' . $id));
$pdf->ln();
$pdf->SetFont('','',$fontSize);
$pdf->Write($fontSize / 2, utf8_decode('Rechnungs Datum: ' . $_POST['date']));;
$pdf->ln();
$pdf->Write($fontSize / 2, utf8_decode('Rechnung Nr. ' . date('Y') . '-' . $id));
$pdf->ln();
$pdf->SetFont('','B', $fontSize * 0.8);
$pdf->Write($fontSize / 2, utf8_decode('Bitte bei Zahlungen und Schriftverkehr angeben!'));
$pdf->SetFont('','',$fontSize);
$pdf->ln();
$pdf->ln();
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.2);
//$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + $pdf->GetPageWidth() - $pdf->margin * 2, $pdf->GetY());
$pdf->ln();
$pdf->SetFont('','B',$fontSize);

$margin = 0;
$y = $pdf->GetY();
$pdf->Cell(50, $fontSize, utf8_decode('Produkt'), 0, 1, 'L');
$margin += 50;
$pdf->SetLeftMargin($pdf->margin + $margin);
$pdf->SetY($y);
$pdf->Cell(80, $fontSize, utf8_decode('Beschreibung'), 0, 1, 'C');
$margin += 80;
$pdf->SetLeftMargin($pdf->margin + $margin);
$pdf->SetY($y);
$pdf->Cell(10, $fontSize, utf8_decode('Position'), 0, 1, 'C');
$margin += 10;
$pdf->SetLeftMargin($pdf->margin + $margin);
$pdf->SetY($y);
$pdf->Cell(40, $fontSize, utf8_decode('Betrag'), 0, 1, 'R');
$pdf->SetFont('','',$fontSize);

$pdf->SetLeftMargin($pdf->margin);

foreach ($_SESSION['articles'] as $article) {

    $margin = 0;
    $y = $pdf->GetY() + $fontSize / 3;
    $pdf->SetY($y);
    $pdf->SetLeftMargin($pdf->margin);
    $pdf->Cell(50, $fontSize / 3, utf8_decode($article['name']));
    $margin += 50;
    $pdf->SetLeftMargin($pdf->margin + $margin);
    $pdf->SetY($y);
    $pdf->Cell(80, $fontSize / 3, utf8_decode($article['desc']));
    $margin += 80;
    $pdf->SetLeftMargin($pdf->margin + $margin);
    $pdf->SetY($y);
    $pdf->Cell(10, $fontSize / 3, utf8_decode($article['pos']), 0, 1, 'C');
    $margin += 10;
    $pdf->SetLeftMargin($pdf->margin + $margin);
    $pdf->SetY($y);
    $pdf->Cell(40, $fontSize / 3, utf8_decode(number_format($article['price'], 2, ',', '.') . ' EUR'), 0, 1, 'R');

    $pdf->SetLeftMargin($pdf->margin);
}
$pdf->ln();
$pdf->ln();
$pdf->SetFont('','B',$fontSize * 1.2);
$pdf->Cell($pdf->GetPageWidth() - 2 * $pdf->margin, $fontSize / 2, utf8_decode('Summe ' . number_format($_SESSION['total'], 2, ',', '.') . ' EUR'), 0, 0, 'R');
$pdf->ln();
$pdf->ln();
$pdf->ln();
$pdf->SetFont('','',$fontSize);
$pdf->Write($fontSize / 2, utf8_decode('Der Gesamtbetrag ist ab Erhalt dieser Rechnung zahlbar innerhalb von 7 Tagen ohne Abzug!'));
$pdf->ln();
$pdf->SetFont('','',$fontSize* 0.8);
$pdf->Write($fontSize / 2 * 0.8, utf8_decode('
Gemäß § 19 UStG enthält der Rechnungsbetrag keine Umsatzsteuer.
Die aufgeführten Dienstleistungen haben Sie gemäß unserer AGB erhalten.
Wenn nicht anders angegeben entspricht das Leistungsdatum dem Rechnungsdatum
'));

$pdf->ln();
$pdf->ln();
$pdf->ln();


if(!isset($_GET['i'])){
    $io->table('invoice')->document($id)->write(array_merge(['id' => $id ], $_POST));
};
if(isset($_POST['id'])) $id = $_POST['id'];
$pdf->SetAuthor('xolf');
$pdf->SetTitle('rechnung-' . $id);
$pdf->Output();
