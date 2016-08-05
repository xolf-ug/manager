<?php include 'bootstrap.php';

if(isset($_GET['i'])) $_POST = json_decode(json_encode($io->table('letter')->document($_GET['i'])), true);

if(isset($_POST['greeter'])) if(trim($_POST['greeter']) == '') unset($_POST['greeter']);

$customer = $io->table('customer')->document($_POST['customer_id']);

$name = $customer->person;
if(trim($name) == "") $name = $customer->name;

$fontSize = 11;

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Source','',10);
$pdf->Cell(0,9 ,utf8_decode($_POST['date']),0,0,'R');
$pdf->ln();
$pdf->ln();
if(isset($_POST['show_id']))
{
    $pdf->Write(5 ,utf8_decode('Kundennummer: ' . $customer->id));
    $pdf->ln();
}
$pdf->SetFont('','',$fontSize + 2);
$pdf->Write($fontSize / 2 ,utf8_decode($customer->name));
$pdf->ln();
$pdf->Write($fontSize / 2 ,utf8_decode($customer->street));
$pdf->ln();
$pdf->Write($fontSize / 2 ,utf8_decode($customer->plz . ' ' . $customer->city));
$pdf->SetFont('','',$fontSize);
$pdf->ln();
$pdf->ln();
$pdf->ln();
$pdf->ln();
if(isset($_POST['subject'])) {
    $pdf->SetFont('','B');
    $pdf->Write($fontSize / 2 ,utf8_decode($_POST['subject']));
    $pdf->ln();
    $pdf->SetFont('','');
}
$pdf->ln();
$salut = 'Sehr geehrte';
if(isset($_POST['salut']) && trim($customer->person) != "") {
    if($customer->salut == 'Herr') $salut .= 'r';
    if(strstr($customer->person, 'Dr.')) $customer->salut .= ' Dr.';
    $lastname = explode(" ",$customer->person);
    $lastname = $lastname[count($lastname)-1];
    $pdf->Write($fontSize / 2 ,utf8_decode($salut . ' ' . $customer->salut . ' ' . $lastname . ','));
}
else if(isset($_POST['salut'])) {
    $pdf->Write($fontSize / 2 ,utf8_decode($salut . ' Damen und Herren,'));
}
$pdf->ln();
$pdf->ln();
$pdf->Write($fontSize / 2 ,utf8_decode($_POST['content']));
if(isset($_POST['greeter']))
{
    $pdf->ln();
    $pdf->ln();
    $pdf->Write($fontSize / 2 ,utf8_decode('Mit freundlichen Grüßen,'));
    $pdf->ln();
    $pdf->ln();
    $pdf->ln();
    $pdf->ln();
    $pdf->ln();
    $pdf->Write($fontSize / 2 ,utf8_decode($_POST['greeter']));
}

$id = count($io->table('letter')->getAllDocuments());
if(!isset($_GET['i'])){
    $io->table('letter')->document($id)->write(array_merge(['id' => $id ], $_POST));
};
if(isset($_POST['id'])) $id = $_POST['id'];
$pdf->SetAuthor('xolf');
$pdf->SetTitle('brief-' . $id);
$pdf->Output();
