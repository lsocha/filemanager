<?php

$file = $_REQUEST['file'];
$dpi=30;
$filetypes = array("jpeg", "jpg", "png", "gif", "bmp", "svg", "tiff", "tif");
$dir = "../images";
$tdir = "$dir/.img-thumbs";
$file = "..".$file;
$thumb = $tdir."/".md5($file.$dpi).".jpg";

if (!file_exists($file)) {
    echo "Brak pliku $file";
    exit();
}
// $max_file_size = 500000;
// $compression_quality = (($max_file_size / filesize($file)) * 100);
//cache
$cachetime = 3 * 24 * 3600; //24h
$time = time();

if((!file_exists($thumb))||($time - filectime($thumb)>$cachetime)) {
                    //cache miss brak pliku lub za stary
                    $img = new Imagick();
                    $img->readImage($file);
                    $img->setImageFormat( "jpg" );
                    $img->setImageCompression(Imagick::COMPRESSION_JPEG);
                    $img->setImageCompressionQuality(70);
                    $img->stripImage();
                    // $img->scaleImage(100, 0);
                    $img->thumbnailImage(100,100,true,true);
                    $img->writeImage($thumb);                     
}

//przekierowuję do pliku jpg
header("Content-Type: image/jpg");
header("Location: ../images/.img-thumbs/".basename($thumb));

// wywołanie
// http://lx.pandora.caps.pl/iapimg/lib/img_thumbs.php?file=/images/ratajkowski.jpeg