<?php

//funcao para upload de imagem (jpg)
function upload($arquivo, $destino, $lar=1280, $alt=960)
{
	$quality = 90; //qualidade (de 0 a 100)
	$wmax = $lar; //largura max
	$hmax = $alt; //altura max
	$source = imagecreatefromjpeg($arquivo['tmp_name']);
	$orig_w = imagesx($source);
	$orig_h = imagesy($source);
		
	if ($orig_w>$wmax || $orig_h>$hmax){
	   $thumb_w = $wmax;
	   $thumb_h = $hmax;
	   if ($thumb_w/$orig_w*$orig_h > $thumb_h) {
		   $thumb_w = round($thumb_h*$orig_w/$orig_h);
	   } else {
		   $thumb_h = round($thumb_w*$orig_h/$orig_w);
	   }
	} 
	else {
	   $thumb_w = $orig_w;
	   $thumb_h = $orig_h;
	}
		
	$thumb = imagecreatetruecolor($thumb_w,$thumb_h);
	imagecopyresampled($thumb,$source,0,0,0,0,$thumb_w,$thumb_h,$orig_w,$orig_h);
	$thumb = stamp($thumb); //marca d agua
		
	if (imagejpeg($thumb, $destino, $quality)){
		return true;
		exit;
	} else {
		return false;
		exit;
	}
		
	imagedestroy($thumb);
}

//marca d agua
function stamp($im)
{
	// Carrega o carimbo e a foto para aplicar a marca d'água
	//$im = imagecreatefromjpeg('photo.jpeg');
	$stamp = imagecreatefrompng('../static/images/logo-stamp.png'); // carimbo

	// Define-se as margens para o carimbo e obtém-se a altura/largura da imagem do carimbo
	$marge_right = 10;
	$marge_bottom = 10;
	
	$sx = imagesx($stamp);
	$sy = imagesy($stamp);

	// $dx = imagesx($im) - $sx - $marge_right;
	// $dy = imagesy($im) - $sy - $marge_bottom;
	$dx = (imagesx($im) - $sx)/2;
	$dy = (imagesy($im) - $sy)/2;

	// Funde o carimbo com a foto usando uma opacidade de 50%
	// (destino, source, dest_x, dest_y, src_x, src_y, src_w, src_h, opacidade)
	imagecopymerge($im, $stamp, $dx , $dy, 0, 0, $sx, $sy, 25);
	

	return $im; //retorna a imagem carimbada

	// Salva a imagem em arquivo
	// imagejpeg($im, 'photo_stamp.png')
	// imagepng($im, 'photo_stamp.png');
}

?>