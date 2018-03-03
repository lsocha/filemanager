<?php
$pdf=$_REQUEST['pdf'];
$dpi=$_REQUEST['dpi'];
$page=$_REQUEST['page'];
$thumb=$_REQUEST['thumb'];

if (!$dpi) $dpi=50;
if (!$page) $page=0;

if (!stripos($pdf,'.pdf')) {
    echo "To nie jest plik PDF";
    exit();
}

$dir = "../images";

$tdir = "$dir/.pdf-thumbs";

if(isset($thumb) && $thumb == 1) $pdf = "..".$pdf;
else $pdf = $dir."/".$pdf;
$thumb = $tdir."/".md5($pdf.$page.$dpi).".jpg";


if (!file_exists($pdf)) {
    echo "Brak pliku $pdf";
    exit();
}

//cache
$cachetime = 3 * 24 * 3600; //24h
$time = time();

if  ((!file_exists($thumb))||($time - filectime($thumb)>$cachetime)) :
                    //cache miss brak pliku lub za stary
                    $img = new Imagick();
                    $img->setResolution($dpi,$dpi);
                    $img->readImage($pdf."[$page]");
                    $img = $img->flattenImages(); 
                    $img->setImageFormat( "jpg" );
                    //$img->setImageCompression(imagick::COMPRESSION_UNDEFINED); 
                    //$img->setImageCompressionQuality(100);
                    $img->setImageCompression(Imagick::COMPRESSION_JPEG);
                    $img->setImageCompressionQuality(75); 
                    $img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
                    $data = $img->getImageBlob();                                        
                    $result = file_put_contents("$thumb",$data);                    
                    //if ($DEBUG) echo "\n$tdir/$nplik"."_pl.png";                                                        
endif;

//przekierowuję do pliku jpg
//echo "Location: images/pdf-thumbs/".basename($thumb);
Header("Location: ../images/.pdf-thumbs/".basename($thumb));

// wywołanie
// lx.pandora.caps.pl/iws2/lib/pdf2jpg.php?pdf=cennik.pdf&dpi=150&page=0&fake=cennik.jpg