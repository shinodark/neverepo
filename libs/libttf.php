<?php

session_start();

$image_width = $_GET['width'];
$image_height = $_GET['height'];
$font = $_GET['font'];
$code = $_GET['text'];

//$possible_letters = '23456789bcdfghjkmnpqrstvwxyz';
//$random_dots = 0;
//$random_lines = 20;
//$i = 0;


$font_size = $image_height * 0.75;
$image = @imagecreate($image_width, $image_height);
$background_color = imagecolorallocate($image, 255, 255, 255);
$id = imagecolortransparent($image,$background_color);

$text_color = imagecolorallocate($image, $_GET['r'], $_GET['g'], $_GET['b']);
$textbox = imagettfbbox($font_size, 0, $font, $code); 
$x = ($image_width - $textbox[4])/2;
$y = ($image_height - $textbox[5])/2;
imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $code);

header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);

?>