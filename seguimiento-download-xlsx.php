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
//error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once 'excelReporte/Classes/PHPExcel.php';
include("model/functions.php");
$model       = new funcionesModel();

// Create new PHPExcel object 
// ******************* REPORTE ACTIVIDAD *******************
$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

/*
 *	 A, B , C , D , E , F , G , H , I, J
 */

$objPHPExcel->getActiveSheet()->setCellValue('A1', utf8_encode('Nombre y Apellido'));

$objPHPExcel->getActiveSheet()->setCellValue('B1', ('Teléfonos'));
$objPHPExcel->getActiveSheet()->setCellValue('C1', ('Teléfonos'));
$objPHPExcel->getActiveSheet()->setCellValue('D1', ('Teléfonos'));

$objPHPExcel->getActiveSheet()->setCellValue('E1', ('Email'));
$objPHPExcel->getActiveSheet()->setCellValue('F1', ('Email'));
$objPHPExcel->getActiveSheet()->setCellValue('G1', ('Email'));

$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Celular');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Celular');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Celular');


$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Tipo de Medio');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Medio');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Clientes');
$objPHPExcel->getActiveSheet()->setCellValue('N1', 'Tema de Interes');
$objPHPExcel->getActiveSheet()->setCellValue('O1', ('Sección'));
$objPHPExcel->getActiveSheet()->setCellValue('P1', utf8_encode('Cargo'));


// Set column widths
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle1->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('rgb' => '#254061')
							)
		 ));

$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:C1");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "D1:P1");

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

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(33);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

// SET COLOR
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('D1:P1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

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

############# SQL ACTIVDADES

$guardar_checkbox = '';
if(count(array_filter($_POST['idActividad'])) !=0){

	$guardar_checkbox =  implode(",",array_filter($_POST['idActividad']));
}

$listaTotal  = $model->datosActividadesReporte($_POST['nombres'],$_POST['tipo_medio'],$_POST['medios_1'],$_POST['cargo'],$_POST['tema_interes'],$_POST['seccionEditar_'],$_POST['clientes'],$guardar_checkbox,'');

 $CCLIENTES = "";	
 for($i=0;$i<count($listaTotal);$i++){
    
	$dataTipoMedio   = $model->listarTablaGeneral(" nombres ","tipo_medios","where id='".$listaTotal[$i]["tipo_medio_id"]."'");
	$dataMedios      = $model->listarTablaGeneral(" nombres ","medios","where id='".$listaTotal[$i]["medio_id"]."'");

	$dataClientes    = $model->listarTablaGeneral(" nombres ","clientes","where id in (".$listaTotal[$i]["clientes_id"].") ");
	for($y=0;$y<count($dataClientes);$y++){
	  $CCLIENTES .=  "/".utf8_encode($dataClientes[$y]['nombres']);
	}

	$TTEMAINTERES = "";
	$dataTemaInteres = $model->listarTablaGeneral(" nombres ","tema_interes","where id  in (".$listaTotal[$i]["tema_interes"].") ");
	for($z=0;$z<count($dataTemaInteres);$z++){  
		$TTEMAINTERES .=  "/".utf8_encode($dataTemaInteres[$z]['nombres']);
	}

	$SSECIONES = "";
	$dataSecciones   = $model->listarTablaGeneral(" nombres ","secciones","where id in(".$listaTotal[$i]["secciones_id"].")");
	for($x=0;$x<count($dataSecciones);$x++){ 
	 $SSECIONES .=  "/".utf8_encode($dataSecciones[$x]['nombres']);
	}

	$dataCargo       = $model->listarTablaGeneral(" nombres ","cargos","where id='".$listaTotal[$i]["cargo_id"]."'");


	$objPHPExcel->getActiveSheet()->setCellValue('A'.($i+2), utf8_encode($listaTotal[$i]["nombres"]." ".$listaTotal[$i]["apellidos"]));
	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.($i+2), utf8_encode($listaTotal[$i]["telefono"])); 	
	$objPHPExcel->getActiveSheet()->setCellValue('C'.($i+2), utf8_encode($listaTotal[$i]["telefonoB"])); 	
	$objPHPExcel->getActiveSheet()->setCellValue('D'.($i+2), utf8_encode($listaTotal[$i]["telefonoC"])); 	


	$objPHPExcel->getActiveSheet()->setCellValue('E'.($i+2), utf8_encode($listaTotal[$i]["emailA"])); 
	$objPHPExcel->getActiveSheet()->setCellValue('F'.($i+2), utf8_encode($listaTotal[$i]["emailB"])); 
	$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+2), utf8_encode($listaTotal[$i]["emailC"])); 

	$objPHPExcel->getActiveSheet()->setCellValue('H'.($i+2), utf8_encode($listaTotal[$i]["celularA"]));	
	$objPHPExcel->getActiveSheet()->setCellValue('I'.($i+2), utf8_encode($listaTotal[$i]["celularB"]));	
	$objPHPExcel->getActiveSheet()->setCellValue('J'.($i+2), utf8_encode($listaTotal[$i]["celularC"]));	


	$objPHPExcel->getActiveSheet()->setCellValue('K'.($i+2), utf8_encode($dataTipoMedio[0]["nombres"])) ;	
	$objPHPExcel->getActiveSheet()->setCellValue('L'.($i+2), utf8_encode($dataMedios[0]["nombres"]));
	$objPHPExcel->getActiveSheet()->setCellValue('M'.($i+2), $CCLIENTES);
	$objPHPExcel->getActiveSheet()->setCellValue('N'.($i+2), $TTEMAINTERES);
	$objPHPExcel->getActiveSheet()->setCellValue('O'.($i+2), $SSECIONES);
	$objPHPExcel->getActiveSheet()->setCellValue('P'.($i+2), utf8_encode($dataCargo[0]['nombres']));

}

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte Periodistas');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// ocultar columnas 

if(!$_POST['CHKPeriodista']){$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setVisible(false);  }
if(!$_POST['CHKTelefono']){  
	
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setVisible(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false); 
}

if(!$_POST['CHKEmail']){    
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setVisible(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setVisible(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);

}

if(!$_POST['CHKCelular']){   
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setVisible(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setVisible(false);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setVisible(false);				
}

if(!$_POST['CHKTMedio']){    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setVisible(false);  }	
if(!$_POST['CHKMedio']){     $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setVisible(false);  }	
if(!$_POST['CHKCliente']){   $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setVisible(false);  }	
if(!$_POST['CHKInteres']){   $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setVisible(false);  }	
if(!$_POST['CHKSeccion']){   $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setVisible(false);  }	
if(!$_POST['CHKCargo']){     $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setVisible(false);  }	


if($listaTotal[$i]["telefonoB"]==''){$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setVisible(false);}
if($listaTotal[$i]["telefonoC"]==''){$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setVisible(false);}

if($listaTotal[$i]["emailB"]==''){	 $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setVisible(false);}
if($listaTotal[$i]["emailC"]==''){	 $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setVisible(false);}

if($listaTotal[$i]["celularB"]==''){	 $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setVisible(false);}
if($listaTotal[$i]["celularC"]==''){	 $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setVisible(false);}


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte-actividad-'.date("Y-m-d").'.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
