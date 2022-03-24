<?php
require('php-pdf-watermark\vendor\fpdf\fpdf.php');
require_once 'php-pdf-watermark\vendor\FPDI\fpdi.php'; // chèn tập tin

$pdf = new Fpdi(); // tạo ra file pdf mới
$pdf->AddPage(); // thêm trang
$pdf->setSourceFile('nhom8_KBDPT.pdf'); // lấy link pdf 
$pagecount = $pdf->SetSourceFile('nhom8_KBDPT.pdf'); // đếm số trang của file pdf có sẵn

for ($i=1; $i<$pagecount;$i++){

    $tplIdx = $pdf->importPage($i); // chèn nội dung của file có sẵn vào file mới
    // $pdf->useTemplate($tplIdx, 0, 0, 200); // full trang
    $pdf->useTemplate($tplIdx, 0, 0, null, null); 
    //Sử dụng template từ góc trên cùng bên trái đến chiều rộng và chiều cao đầy đủ
    /** viết nội dung(kiêu như copy ấy)
     * khoảng cách vs lề trái
     * khoảng cách vs lề trên
     * scale
     */
    // $pdf->SetFont('Helvetica', 'B', 20); // Font Name, Font Style (eg. 'B' for Bold), Font Size
    //  nếu muốn dùng đầy đủ thì như trên còn dưới cx được
    $pdf->SetFont('Helvetica'); // font chữ
    $pdf->SetTextColor(255, 0, 0); // màu hệ RGB nhé
    //$pdf->SetXY(30, 30);
    //đặt vị trí của con trỏ

    // $pdf->Cell(215.9, 20, 'This text goes to middle', 0, 2, 'C');
    //cách khác để thêm text
    $pdf->Write(0, 'Bản quyền số'); // cái này là để ghi text vào, thông số đầu là trục Oy
    $pdf->Cell(0, 0, 'https://www.facebook.com/groups/674990933524304', 0, 2, 'C'); 
    // Thêm link có đầy đủ chiều rộng và chiều cao của trang phông chữ 
    /** add link,
     *  thông số đầu là theo Ox nếu là 0 thì link sẽ nằm bên tay phải
     * thông số thứ hai là vị trí theo Oy
     * thứ 3 là link cần thêm
     */
    
    // $pdf->Image('275439697_979128029394650_1212354240896596129_n.png', 40, 100, 100, 0, 'PNG'); // them hình ảnh
    $pdf->Image('F:\OneDrive - ptit.edu.vn\Hoc_ky_6\Ban_quyen_so\PHP\logo2.png' ,40,100,100,0);
    /** chèn ảnh
     * Link ảnh
     * cách lề trái bao nhiêu
     * cách lề trên bao nhiêu
     * lề dưới
     * lề phải
     */
    $pdf->AddPage();
    // thêm trang 
}
 
$pdf->Output('Huong.pdf'); // xuất file