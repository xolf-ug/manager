<?php

include 'fpdf.php';

class PDF extends FPDF
{
    public $margin = 15;

    function __construct($orientation='P', $unit='mm', $size='A4')
    {
        parent::__construct($orientation, $unit, $size);

        $this->AddFont('Source','','source.php');

        $this->AddFont('Source','B','sourceb.php');

        $this->AddFont('Source','BI','sourcebi.php');

        $this->SetFont('Source','',12);

        $this->SetMargins($this->margin,10,$this->margin);

    }

    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        $x = $this->margin+$col*42;
        $this->SetLeftMargin($x);
        //$this->SetX($x);
    }

// Page header
    function Header()
    {
        // Logo
        $this->Image('logo.png',16,6,30);
        // Arial bold 15
        $this->SetFont('Source','B',9);
        $this->Ln(7);
        $this->Write(9,utf8_decode('xolf UG (haftungsbeschränkt)'));
        $this->SetFont('','');
        $this->Write(9,utf8_decode(' - Forstenrieder Weg 1g - 82065 Baierbrunn'));
        $this->ln();
        $this->ln();
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-30);
        // Arial italic 8
        $this->SetFont('Source','',9);

        $this->SetCol(0);
        // Page number
        $this->SetFont('','B');
        $this->Write(4.5,utf8_decode('Geschäftsführer'));
        $this->ln();
        $this->SetFont('','');
        $this->Write(4.5,utf8_decode('Dr. Thomas Theimer'));
        $this->ln();
        $this->SetFont('','B');
        $this->Write(4.5,utf8_decode('Handelsregister'));
        $this->ln();
        $this->SetFont('','');
        $this->Write(4.5,utf8_decode('München HRB 225495'));
        $this->ln();

        $this->SetCol(1);
        $this->SetY(-30);
        // Page number
        $this->SetFont('','B');
        $this->Write(4.5,utf8_decode('Adresse'));
        $this->ln();
        $this->SetFont('','');
        $this->Write(4.5,utf8_decode('xolf UG (haftungsbeschränkt)'));
        $this->ln();
        $this->Write(4.5,utf8_decode('Forstenrieder Weg 1g'));
        $this->ln();
        $this->Write(4.5,utf8_decode('82065 Baierbrunn'));
        $this->ln();

        $this->SetCol(2);
        $this->SetY(-30);
        // Page number
        $this->SetFont('','B');
        $this->Write(4.5,utf8_decode('Kontakt'));
        $this->ln();
        $this->SetFont('','');
        $this->Write(4.5,utf8_decode('Tel.: +49 (0) 89 4117 3607'));
        $this->ln();
        $this->Write(4.5,utf8_decode('Website: https://xolf.info'));
        $this->ln();

        $this->SetCol(3);
        $this->SetY(-30);
        // Page number
        $this->SetFont('','B');
        $this->Write(4.5,utf8_decode('Bankverbindung'));
        $this->ln();
        $this->SetFont('','');
        $this->Write(4.5,utf8_decode('Raiffaisenbank Isar-Loisachtal eG'));
        $this->ln();
        $this->Write(4.5,utf8_decode('IBAN: DE88 7016 9543 0000 1260 20'));
        $this->ln();
        $this->Write(4.5,utf8_decode('BIC: GENODEF1HHS'));
        $this->ln();
    }
}
