<?php 
//header("Content-type:application/vnd.ms-excel"); 
//header("Content-Disposition:attachment; filename=test_data.xls");
header("Content-Type: text/html; charset=UTF-8");
include('./Classes/PHPExcel.php');
$objPHPExcel = new PHPExcel();

//转换字符串
function str($str){
    $str  = iconv('gb2312', 'utf-8', $str);
    return $str;
}

//跳转功能
$db=new mysqli('localhost','root','chenzeshu8','workbase');
$db->set_charset('GBK');
if($db->connect_errno){
    echo "没有连接数据库";
    }else{
    echo "已连接";
        
        $objPHPExcel-> setActiveSheetIndex(0)
        -> setCellValue('A1','序号')
        -> setCellValue('B1','名称')
        -> setCellValue('C1','设备规格')
        -> setCellValue('D1','设备描述');
		
    $query="select * from workcontent";
    $result=$db->query($query);
    for($i=2;$row=$result->fetch_assoc();$i++){
        
        $objPHPExcel-> setActiveSheetIndex(0)
        -> setCellValue('A'.$i,str($row["id"]))
        -> setCellValue('B'.$i,str($row["name"]))
        -> setCellValue('C'.$i,str($row["brand"]))
        -> setCellValue('D'.$i,str($row["des"]));
		$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);//水平方向上两端对齐
    }
//宽
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
 




    
    
    
    $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
    $objWriter->save(str_replace('.php','.xls',__FILE__));

    /*这个生成是生成在服务器上。   所谓的另存为，是客户端行为，是从服务器上提取，PHP下载 是提交动态查询，让PHP把查询的结果返回给你，结果可能就是下载地址
      其实也非常简单，比如知道地址是web.chenzeshu.com/classes/index.xls，那么做一个button,onclick=下载地址就行了？*/
    
    echo date('H:I:S') . " peak memory usage: " .(
        memory_get_peak_usage(true) / 1024 / 1024) . "MB\r\n";
    
    echo date('H:I:S') . "Done writing file.\r\n";
    }


?>