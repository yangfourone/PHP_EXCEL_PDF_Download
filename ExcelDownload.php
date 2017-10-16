<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

// 連結資料庫
$dbhost = 'localhost';   
$dbuser = 'root';   
$dbpass = 'qcg444ntn';   
$dbname = 'insert_delete_test';

$conn = mysql_connect($dbhost, $dbuser, $dbpass );
mysql_select_db($dbname);  
 
// query資料庫的資料 
$sql_query = "select * from student_data";
mysql_query("SET NAMES 'utf8'");
$result = mysql_query($sql_query); 

$_cnt = 0;

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel-1.8/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// 將資料庫的資料全部存在student這個陣列
while($row = mysql_fetch_array($result)) {
	$_cnt++;
	$objPHPExcel->setActiveSheetIndex()
		->setCellValue('A'.$_cnt , $row['number'])
		->setCellValue('B'.$_cnt , $row['name'])
		->setCellValue('C'.$_cnt , $row['junior'])
		->setCellValue('D'.$_cnt , $row['wish']);
}


// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Number')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Junior')
            ->setCellValue('D1', 'Wish');
			
$data_number = 0 ;

/*
// Set some data into a specific place (ex:A2,B3)			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A2', $student[$data_number]['number'])
            ->setCellValue('B2', $student[$data_number]['name'])
            ->setCellValue('C2', $student[$data_number]['junior'])
            ->setCellValue('D2', $student[$data_number]['wish']);
*/
			
// Miscellaneous glyphs, UTF-8
/*$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$data_number, 'This is A4')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
*/
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

//***************************file name***************************************
header('Content-Disposition: attachment;filename="01simple.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
