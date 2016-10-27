<?php
error_reporting(E_ALL);
set_time_limit(1800);
set_include_path('../src/' . PATH_SEPARATOR . get_include_path());

include 'Cezpdf.php';

class Creport extends Cezpdf{
	function Creport($p,$o){
  		$this->__construct($p, $o);
	}
}

$pdf = new Creport('a4','portrait');

// to test on windows xampp
if(strpos(PHP_OS, 'WIN') !== false){
    $pdf->tempPath = 'C:/temp';
}

if (isset($_GET['nohash'])){
	$pdf->hashed = false;
}

$pdf -> ezSetMargins(20,20,20,20);

$mainFont = 'Times-Roman';
// select a font
$pdf->selectFont($mainFont);
$size=12;

$height = $pdf->getFontHeight($size);
// modified to use the local file if it can
$pdf->openHere('Fit');

$pdf->ezText("Since version 011 object hash is enabled to reduce the pdf size when redundant images are used");
$pdf->ezText("This image below has a size of <b>".filesize('../ros.jpg').' bytes</b>');
$pdf->ezText("So the object is being hashed and reused 3 times in this examples");
$pdf->ezText("The XObject always refers to the same object number.");
$pdf->ezText("Put <b>'?nohash'</b> to disable object hashing\n\n");
$pdf->ezImage('../ros.jpg',0,0,'none','left');
$pdf->ezImage('../ros.jpg',0,0,'none','center');
$pdf->ezImage('../ros.jpg',0,0,'none','right');

if (isset($_GET['d']) && $_GET['d']){
  echo $pdf->ezOutput(TRUE);
} else {
  $pdf->ezStream(array('compress'=>0));
}

//error_log($pdf->messages);
?>