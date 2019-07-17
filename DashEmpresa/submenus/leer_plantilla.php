<?php
  
  	require_once('../PHPExcel/Classes/PHPExcel.php');

  	// $formatos = array('.xlsx', '.xls');

  	function ValidarFolio($variable){
        
	   $permitidos = "0123456789"; 
	   $flag = true;
	   for ($i=0; $i<strlen($variable); $i++){ 
		    if (strpos($permitidos, substr($variable,$i,1))===false){ 
		        $flag = false;
		        break;
		    } 
	    }
        return $flag;  		
  	}

  	if (isset($_POST['plantilla'])) {


   		$NombreArchivo = $_POST['plantilla'];
  		$RutaArchivo = "archivostemp/".$NombreArchivo;

		$inputFileType = PHPExcel_IOFactory::identify($RutaArchivo);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($RutaArchivo);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

  		if ($_POST['validacion']==1) {
			$TipoDocto = $sheet->getCell("M1")->getValue();
			$TipoDoctoDet = $sheet->getCell("M2")->getValue();
			//$Folio = $sheet->getCell("F5")->getValue();
			//$Serie = $sheet->getCell("G5")->getValue();

			//$FechaDocto = $sheet->getCell("E5")->getValue();

			if($TipoDoctoDet != "" || $TipoDocto != ""){
				$encabezado[0] = array("tipodocto" => $TipoDocto, "tipodoctodet" => $TipoDoctoDet);
			}else{
				$encabezado[0] = array("tipodocto" => "Error", "tipodoctodet" => "Error");
				unlink("../submenus/archivostemp/".$NombreArchivo);					
			}

			echo json_encode($encabezado);


  		}else if($_POST['validacion']==2){  			
  			$row2 = 7;
  			$i = 0;
  			$foliotmp = "";
  			$fechatmp = "";
			$idconce = $sheet->getCell("M1")->getValue();
			$concepto = $sheet->getCell("M2")->getValue();

			if($idconce == 3){	//Remisiones
				
				for ($row = 7; $row <= $highestRow; $row++){				
					//$fecha = date($format = "d/m/y", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("B".$row)->getValue()));
					if(is_null($sheet->getCell("K".$row)->getValue()) == false && is_null($sheet->getCell("H".$row)->getValue()) == false && $sheet->getCell("M".$row)->getValue() != "A"){
						
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$folio = $sheet->getCell("B".$row)->getValue();
						$serie = $sheet->getCell("C".$row)->getValue();
						$proveedor = $sheet->getCell("D".$row)->getValue();
						$concepto2 = $sheet->getCell("E".$row)->getValue();
						$producto = $sheet->getCell("F".$row)->getValue();
						$cantidad = $sheet->getCell("G".$row)->getValue();
						$neto = $sheet->getCell("H".$row)->getValue();
						$desc = $sheet->getCell("I".$row)->getValue();
						$iva = $sheet->getCell("J".$row)->getValue();
						$total = $sheet->getCell("K".$row)->getValue();

						$movtos[$i] = array("fecha" => $fecha, "concepto" => $concepto2, "proveedor" => $proveedor, "producto" => $producto, "folio" => $folio, "serie" => $serie, "cantidad" => $cantidad, "subtotal" => $neto, "descuento" => $desc, "iva" => $iva, "total" => $total, "idconce" => $idconce, "estatus" => "", "codigo" => "");

						$TotalNeto = 0; 
						$TotalDesc = 0;
						$TotalIVA = 0;
						$TotalDoc = 0;

						$foliotmp = $folio;
						$fechatmp = $fecha;					

						
						for ($numf = 7; $numf <= $highestRow; $numf++){ //recorremos los movimientos y acumulamos si cumplen los filtros
						   if(is_null($sheet->getCell("K".$numf)->getValue()) == false && is_null($sheet->getCell("H".$numf)->getValue()) == false && $sheet->getCell("M".$numf)->getValue() != "A"){					   		
								$fechamov = $sheet->getCell("A".$numf)->getValue();
								$fechamov = PHPExcel_Shared_Date::ExcelToPHP($fechamov);
								$fechamov = date("Y-m-d", $fechamov);					   		
								
								if(ValidarFolio($sheet->getCell("B".$numf)->getValue()) == true){
									if($sheet->getCell("B".$numf)->getValue() == $foliotmp && $fechamov == $fechatmp){

										$TotalNeto = $TotalNeto + $sheet->getCell("H".$numf)->getValue();
										$TotalDesc = $TotalDesc + $sheet->getCell("I".$numf)->getValue();
										$TotalIVA = $TotalIVA + $sheet->getCell("J".$numf)->getValue();
										$TotalDoc = $TotalDoc + $sheet->getCell("K".$numf)->getValue();
										$movtos[$i]["subtotal"] = $TotalNeto;
										$movtos[$i]["descuento"] = $TotalDesc;
										$movtos[$i]["iva"] = $TotalIVA;
										$movtos[$i]["total"] = $TotalDoc;								
										
										$sheet->setCellValue("M".$numf, "A");
									}
								}
								$foliotmp = $folio;
								$fechatmp = $fechamov;
							}
						}
						$i = $i + 1;
					}
				}
			}else{ //if($idconce == 2){ //Consumo Diesel	
				//echo "Diesel";		
				for ($row = 7; $row <= $highestRow; $row++){					
					if(is_null($sheet->getCell("A".$row)->getValue()) == false){
					
            		
						$fecha = $sheet->getCell("A".$row)->getValue();

						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$concepto2 = $sheet->getCell("B".$row)->getValue();
						$proveedor = $sheet->getCell("C".$row)->getValue();
						$almacen = $sheet->getCell("D".$row)->getValue();
						$producto = $sheet->getCell("E".$row)->getValue();
						$litros = $sheet->getCell("F".$row)->getValue();
						$importe = $sheet->getCell("G".$row)->getValue();
						$kilometro = $sheet->getCell("H".$row)->getValue();
						$horometro = $sheet->getCell("I".$row)->getValue();
						$unidad = $sheet->getCell("J".$row)->getValue();
						//$total = number_format($sheet->getCell("K".$row)->getValue());

						$movtos[$i] = array("fecha" => $fecha, "concepto" => $concepto2, "proveedor" => $proveedor, "producto" => $producto, "almacen" => $almacen, "litros" => $litros, "importe" => $importe, "kilometro" => $kilometro, "horometro" => $horometro, "unidad" => $unidad, "idconce" => $idconce, "estatus" => "", "codigo" => "");

						$i = $i + 1;							
						
					}
				}

			}			


			if($i == 0){
				$movtos[0] = array("fecha" => "Vacio", "codprod" => "Vacio", "cantidad" => "Vacio", "neto" => "Vacio", "descuento" => "Vacio", "iva" => "Vacio", "total" => "Vacio");
			}
			
			echo json_encode($movtos);


//VALIDACION TIPO 3 -> REGRESA UN ARREGLO CON LOS MOVIMIENTOS.
		}else if($_POST['validacion']==3){ 

  			$idconce = $sheet->getCell("M1")->getValue();
			//$concepto = $sheet->getCell("M2")->getValue();
  			//$codigo = $_POST['codigo'];
  			$i = 0;  			
			for ($row = 7; $row <= $highestRow; $row++){				
				if($idconce == 2){
					if(is_null($sheet->getCell("J".$row)->getValue()) == false){

						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$concepto2 = $sheet->getCell("B".$row)->getValue();
						$proveedor = $sheet->getCell("C".$row)->getValue();
						$almacen = $sheet->getCell("D".$row)->getValue();
						$producto = $sheet->getCell("E".$row)->getValue();
						$litros = $sheet->getCell("F".$row)->getValue();
						$importe = $sheet->getCell("G".$row)->getValue();
						$kilometro = $sheet->getCell("H".$row)->getValue();
						$horometro = $sheet->getCell("I".$row)->getValue();
						$unidad = $sheet->getCell("J".$row)->getValue();

						$movtos[$i] = array("fecha" => $fecha, "concepto" => $concepto2, "proveedor" => $proveedor, "producto" => $producto, "almacen" => $almacen, "litros" => $litros, "importe" => $importe, "kilometro" => $kilometro, "horometro" => $horometro, "unidad" => $unidad);

						$i = $i + 1; 						

					}
				}else if($idconce == 3){
					if(is_null($sheet->getCell("K".$row)->getValue()) == false && is_null($sheet->getCell("H".$row)->getValue()) == false){

						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$concepto2 = $sheet->getCell("E".$row)->getValue();
						$proveedor = $sheet->getCell("D".$row)->getValue();
						$folio = $sheet->getCell("B".$row)->getValue();
						$producto = $sheet->getCell("F".$row)->getValue();
						$serie = $sheet->getCell("C".$row)->getValue();
						$cantidad = $sheet->getCell("G".$row)->getValue();
						$subtotal = $sheet->getCell("H".$row)->getValue();
						$descuento = $sheet->getCell("I".$row)->getValue();
						$iva = $sheet->getCell("J".$row)->getValue();
						$total = $sheet->getCell("K".$row)->getValue();

						$movtos[$i] = array("fecha" => $fecha, "concepto" => $concepto2, "proveedor" => $proveedor, "producto" => $producto, "folio" => $folio, "serie" => $serie, "cantidad" => $cantidad, "subtotal" => $subtotal, "descuento" => $descuento, "iva" => $iva, "total" => $total);

						$i = $i + 1; 						

					}					
				}

			}	

			//unlink("../submenus/archivostemp/".$NombreArchivo);

			echo json_encode($movtos);

  		}

  	}



?>