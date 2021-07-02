<?php
session_start();
header("Content-type:image/png");
$kep=imagecreate(250,60);
$hatter=imagecolorallocate($kep,230,230,230);
$betukeszlet="../modules/times.ttf";
$x=5;
foreach($_SESSION["titkos"] as $betu)
{
	$velszin=imagecolorallocate($kep,rand(0,220),rand(0,220),rand(0,220));
	imageTTFtext($kep,rand(24,32),rand(-5,5),$x+rand(40,45),rand(40,45),$velszin,$betukeszlet,$betu);
	$x=$x+20;
}
imagepng($kep);
?>