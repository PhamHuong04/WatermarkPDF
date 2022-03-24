<?php
require('php-pdf-watermark\vendor\fpdf\fpdf.php');
require_once 'php-pdf-watermark\vendor\FPDI\fpdi.php'; // chèn tập tin

class PDF_Rotate extends FPDI {

    var $angle = 0;

    // hàm này để quay chữ
    function Rotate($angle, $x = -1, $y = -1) {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle*=M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    // nó kiểu như đóng file ấy
    function _endpage() {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

}
class PDF extends PDF_Rotate {
    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}
$pdf = new PDF();
// $pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile('nhom8_KBDPT.pdf');
$pagecount = $pdf->SetSourceFile('nhom8_KBDPT.pdf');

for ($i=1; $i<$pagecount;$i++){

    $tplIdx = $pdf->importPage($i);
     
    $pdf->useTemplate($tplIdx, 0, 0, 200);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetTextColor(255, 0, 0);
    //$pdf->SetXY(30, 30);
    for ($i=1;$i<5;$i++){
        $pdf->RotatedText(200, 500, 'Xin chao', 45); 
    }
    $pdf->AddPage();

}
 
$pdf->Output('Huong.pdf');