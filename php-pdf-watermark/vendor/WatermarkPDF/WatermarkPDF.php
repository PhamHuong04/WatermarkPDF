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



$fullPathToFile = "nhom8_KBDPT.pdf"; // file để write watermark


class PDF extends PDF_Rotate {

    var $_tplIdx;

    function Header() {
        global $fullPathToFile; // truy suất biến toàn cục trong hàm
        
        //Put the watermark
        $this->Image('http://chart.googleapis.com/chart?cht=p3&chd=t:60,40&chs=250x100&chl=Hello|World', 40, 100, 100, 0, 'PNG'); // them hình ảnh
        $this->SetFont('Arial', 'B', 50); // set font chữ
        $this->SetTextColor(255, 192, 203); // màu sắc
        $this->RotatedText(20, 230, 'Xin chao', 45); 

        
        if (is_null($this->_tplIdx)) {

            // THIS IS WHERE YOU GET THE NUMBER OF PAGES
            $this->numPages = $this->setSourceFile($fullPathToFile);
            $this->_tplIdx = $this->importPage(2); // chọn trang để thêm watermark
        }
        $this->useTemplate($this->_tplIdx, 0, 0, 200); // giữ nguyên nội dung của pdf - nếu ko có thì thành trang trắng
        
        
    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}


$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
$pdf->Output('Huong.pdf');