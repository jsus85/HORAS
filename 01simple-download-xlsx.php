<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2011 PHPExcel
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
 * @copyright  Copyright (c) 2006 - 2011 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once 'excelReporte/Classes/PHPExcel.php';
include("model/functions.php");
$model       = new funcionesModel();

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");



$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_decode('Codigo')); 
$objPHPExcel->getActiveSheet()->setCellValue('B1', utf8_decode('Nombres')); 
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Teléfono'); 
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Anexo');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Celular 1');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Celular 2');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Emai 1');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Emai 2');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Nacimiento');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Ciudad');


// Set column widths
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle1->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							)
		 ));

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:C1");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "D1:J1");

$sharedStyle2 = new PHPExcel_Style();
$sharedStyle2->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							)
		 ));
/*
$objPHPExcel->getActiveSheet()->getStyle('L1:M2')->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							),
		 )
	);
*/

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(35);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);


// SET COLOR
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('D1:J1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

// ALINEAR = CENTRO
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

############# SQL PERIODISTAS

$listaTotal  = $model->datosPeriodista($_GET['nombres'],$_GET['ciudad'],'');
//$num_servicios = mysql_num_rows($rs_servicios);


 for($i=0;$i<count($listaTotal);$i++){
    
    $data1 = $model->listarTablaGeneral(" nombres ","ciudades","where id='".$listaTotal[$i]["ciudad_id"]."'");

	$objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), $listaTotal[$i]["codigo"]);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), utf8_encode($listaTotal[$i]["nombres"]));	
	$objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), $listaTotal[$i]["telefono"]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), $listaTotal[$i]["anexo"]);	
	$objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), $listaTotal[$i]["celularA"]);	
	$objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), $listaTotal[$i]["celularB"]);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), $listaTotal[$i]["emailA"]);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), $listaTotal[$i]["emailB"]);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), $listaTotal[$i]["nacimiento"]);
	$objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2), $data1[0]['nombres']);

}



// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte Periodistas');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// $objPHPExcel->getActiveSheet()->removeColumn('A');
if($_GET['codigo']==0){		 $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setVisible(false);  }
if($_GET['name']==0){ 	 	 $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setVisible(false); }
if($_GET['telefonos']==0){   $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false); }
if($_GET['anexo']==0){		 $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false); }
if($_GET['movil']==0){ 		 $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(false);
							 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setVisible(false);
							}
if($_GET['email']==0){		 
							$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);
							$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setVisible(false);}
if($_GET['cumpleanios']==0){ $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setVisible(false); }
if($_GET['ciu']==0){ 		 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setVisible(false); }
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte-periodistas-'.date("Y-m-d").'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
