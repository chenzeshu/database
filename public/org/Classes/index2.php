<?php
    header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type:application/vnd.ms-execl");
header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header('Content-Disposition:attachment;filename="resume.xls"');
header("Content-Transfer-Encoding:binary");
	include('./PHPExcel.php');
	include('./PHPExcel/Writer/Excel5.php');
	include('./PHPExcel/IOFactory.php');
	$objPHPExcel = new PHPExcel();
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("xxx.xlsx");
	
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);

$objWriter->save('php://output');

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");

$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");

$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");

$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");

$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");

$objPHPExcel->getProperties()->setCategory("Test result file");


$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('D13')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E13')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('D13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);

$objPHPExcel->getActiveSheet()->getStyle('A18')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()->getStyle('D13')->getBorders()->getLeft()->getColor()->setARGB('FF993300');
$objPHPExcel->getActiveSheet()->getStyle('D13')->getBorders()->getTop()->getColor()->setARGB('FF993300');
$objPHPExcel->getActiveSheet()->getStyle('D13')->getBorders()->getBottom()->getColor()->setARGB('FF993300');
$objPHPExcel->getActiveSheet()->getStyle('E13')->getBorders()->getTop()->getColor()->setARGB('FF993300');
$objPHPExcel->getActiveSheet()->getStyle('E13')->getBorders()->getBottom()->getColor()->setARGB('FF993300');
$objPHPExcel->getActiveSheet()->getStyle('E13')->getBorders()->getRight()->getColor()->setARGB('FF993300');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('FF808080');
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFill()->getStartColor()->setARGB('FF808080');

 $str  = iconv('gb2312', 'utf-8', $str);
 
 
 $db = new Mysql('localhost','root','chenzeshu8','workbase');
 if($db->connect_errno){
     $sql = "SELECT * FROM  workcontent";
     $row = $db->query($sql);  
     
     for ($i = 2; $i <= ($row->assoc()+1); $i++) {
         $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, convertUTF8($row[$i-2][1]));
         $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, convertUTF8($row[$i-2][2]));
         $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, convertUTF8($row[$i-2][3]));
         $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, convertUTF8($row[$i-2][4]));
     }
     
     echo date('H:i:s') . " Create new Worksheet object\n";
     $objPHPExcel->createSheet();
     $objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
     $objWriter->save('php://output');
 }else{
     echo "未连接数据库";
 }

?>