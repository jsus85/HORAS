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
require_once '../Classes/PHPExcel.php';
require_once '../../../include/basedatos.php';



// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

$objPHPExcel->getActiveSheet()->setCellValue('A1', 'REPORTE DE INGRESOS');


$objPHPExcel->getActiveSheet()->setCellValue('A2', utf8_decode('Servicios'));
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Monto');


$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Concepto');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Monto S/.');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Monto $.');


// Set column widths
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle1->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							)
		 ));

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A2:C2");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "G2:I2");

$sharedStyle2 = new PHPExcel_Style();
$sharedStyle2->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							)
		 ));

/*$objPHPExcel->getActiveSheet()->getStyle('L1:M2')->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							),
		 )
	);
*/

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);

$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);


// SET COLOR
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('G2:I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

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

############# SERVICIOS
$rs_servicios  = mysql_query("select codigo_qr,fecha_registro,presupuesto from servicios where acepta_presupuesto = 1 and date(fecha_registro) between '".$_GET['fecini']."' and '".$_GET['fecfin']."'  order by fecha_registro desc") or die(mysql_error());
$num_servicios = mysql_num_rows($rs_servicios);

$i=2;
$monto = 0;
while($rw_servicios = mysql_fetch_array($rs_servicios)){
	$i++;
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $rw_servicios['codigo_qr']);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rw_servicios['fecha_registro']);	
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rw_servicios['presupuesto']);
	$monto += $rw_servicios['presupuesto'];
}
//  End while

$objPHPExcel->getActiveSheet()->setCellValue('B'.($num_servicios+3), 'Total Ingresos:');
$objPHPExcel->getActiveSheet()->setCellValue('C'.($num_servicios+3), number_format($monto,2));
// Color
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A".($num_servicios+3).":C".($num_servicios+3));
// SET COLOR
$objPHPExcel->getActiveSheet()->getStyle('A'.($num_servicios+3).':C'.($num_servicios+3))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

############# CONCEPTOS / INGRESOS  
$rs_concepto = mysql_query("select * from conceptos order by nombres asc");
$num_concepto = mysql_num_rows($rs_concepto); 
$x=2;
$monto_ingreso = 0;
while($rw_concepto = mysql_fetch_array($rs_concepto)){	
	$x++;

	$rwGastoIngreso = mysql_fetch_array(mysql_query("select monto from gastos_ingresos where concepto_id = '".$rw_concepto['id']."' and date(fecha) between '".$_GET['fecini']."' and '".$_GET['fecfin']."'  "));

	$objPHPExcel->getActiveSheet()->setCellValue('G'.$x, utf8_encode($rw_concepto['nombres']));
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$x, $rwGastoIngreso['monto']);	
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$x, '');
	$monto_ingreso += $rw_concepto['presupuesto'];
}
//  End while
$objPHPExcel->getActiveSheet()->setCellValue('G'.($num_concepto+3), 'Total Ingresos:');
$objPHPExcel->getActiveSheet()->setCellValue('H'.($num_concepto+3), number_format($monto_ingreso,2));

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte Servicios Aceptados');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="servicios-aceptados-'.date("Y-m-d").'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
