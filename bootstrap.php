<?php
include 'vendor/autoload.php';

include 'pdf.php';

$io = new Xolf\io\Client(__DIR__ . '/io-db');

$inputs = [
    ['name', 'Name'],
    ['street', 'Straße'],
    ['plz', 'Postleitzahl'],
    ['city', 'Ort'],
    ['country', 'Land'],
];
$company = [
    ['salut', 'Anrede'],
    ['person', 'Inhaber'],
    ['tel', 'Telefon'],
    ['mail', 'E-Mail'],
    ['website', 'Webseite'],
];

?>
