<?php
// LOAD SOURCE IMAGE
$img = imagecreatefromjpeg("anime2-02.jpg");

//WRITE
$wmtxt = "Love me";
$wmfont ="F:\\OneDrive - ptit.edu.vn\\font\\SVN-Sofia.ttf";
$wmsize = 100;
$wmcolor = imagecolorallocatealpha($img, 255, 0, 0, 75); //RED
$posX = 100;
$posY = 100;
imagettftext($img, $wmsize, 0, $posX, $posY, $wmcolor, $wmfont, $wmtxt);
 
//SAVE
imagejpeg($img, "watermark.jpg",60);
echo "OK";

?>
