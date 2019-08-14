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
			$TipoDocto = $sheet->getCell("Z1")->getValue();
			$TipoDoctoDet = $sheet->getCell("Z2")->getValue();
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
			$idconce = $sheet->getCell("Z1")->getValue();
			$concepto = $sheet->getCell("Z2")->getValue();

			if($idconce == 3){	//Remisiones
				
				for ($row = 7; $row <= $highestRow; $row++){				
					//$fecha = date($format = "d/m/y", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("B".$row)->getValue()));
					if(is_null($sheet->getCell("K".$row)->getValue()) == false && is_null($sheet->getCell("H".$row)->getValue()) == false && $sheet->getCell("Z".$row)->getValue() != "A"){
						
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$folio = $sheet->getCell("B".$row)->getValue();
						$serie = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();
						$razonsocial = $sheet->getCell("E".$row)->getValue();
						$codigoconcepto = $sheet->getCell("F".$row)->getValue();						
						$concepto = $sheet->getCell("G".$row)->getValue();
						$codigoproducto = $sheet->getCell("H".$row)->getValue();
						$producto = $sheet->getCell("I".$row)->getValue();
						$cantidad = $sheet->getCell("J".$row)->getValue();
						$subtotal = $sheet->getCell("K".$row)->getValue();
						$descuento = $sheet->getCell("L".$row)->getValue();
						$iva = $sheet->getCell("M".$row)->getValue();
						$total = $sheet->getCell("N".$row)->getValue();
						$suc = $sheet->getCell("O".$row)->getValue();						

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "folio" => $folio, "serie" => $serie, "cantidad" => $cantidad, "subtotal" => $subtotal, "descuento" => $descuento, "iva" => $iva, "total" => $total, "sucursal" => $suc ,"idconce" => $idconce, "estatus" => "", "codigo" => "");

						$TotalNeto = 0; 
						$TotalDesc = 0;
						$TotalIVA = 0;
						$TotalDoc = 0;

						$foliotmp = $folio;
						$fechatmp = $fecha;	
						$suctemp = $suc;				

						
						for ($numf = 7; $numf <= $highestRow; $numf++){ //recorremos los movimientos y acumulamos si cumplen los filtros
						   if(is_null($sheet->getCell("N".$numf)->getValue()) == false && is_null($sheet->getCell("K".$numf)->getValue()) == false && $sheet->getCell("Z".$numf)->getValue() != "A"){					   		
								$fechamov = $sheet->getCell("A".$numf)->getValue();
								$fechamov = PHPExcel_Shared_Date::ExcelToPHP($fechamov);
								$fechamov = date("Y-m-d", $fechamov);					   		
								
								if(ValidarFolio($sheet->getCell("B".$numf)->getValue()) == true){
									if($sheet->getCell("B".$numf)->getValue() == $foliotmp && $fechamov == $fechatmp && $sheet->getCell("O".$numf)->getValue() == $suctemp){

										$TotalNeto = $TotalNeto + $sheet->getCell("K".$numf)->getValue();
										$TotalDesc = $TotalDesc + $sheet->getCell("L".$numf)->getValue();
										$TotalIVA = $TotalIVA + $sheet->getCell("M".$numf)->getValue();
										$TotalDoc = $TotalDoc + $sheet->getCell("N".$numf)->getValue();
										$movtos[$i]["subtotal"] = $TotalNeto;
										$movtos[$i]["descuento"] = $TotalDesc;
										$movtos[$i]["iva"] = $TotalIVA;
										$movtos[$i]["total"] = $TotalDoc;								
										
										$sheet->setCellValue("Z".$numf, "A");
									}
								}
								$foliotmp = $folio;
								$fechatmp = $fechamov;
								$suctemo = $suc;
							}
						}
						$i = $i + 1;
					}
				}
			}else if($idconce == 2){  //Consumo Diesel	
			
				for ($row = 7; $row <= $highestRow; $row++){					
					if(is_null($sheet->getCell("A".$row)->getValue()) == false){				
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("B".$row)->getValue();
						$concepto = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();
						$razonsocial = $sheet->getCell("E".$row)->getValue();
						$codigoproducto = $sheet->getCell("F".$row)->getValue();
						$producto = $sheet->getCell("G".$row)->getValue();
						$almacen = $sheet->getCell("H".$row)->getValue();
						$litros = $sheet->getCell("I".$row)->getValue();
						$importe = $sheet->getCell("J".$row)->getValue();
						$kilometros = $sheet->getCell("K".$row)->getValue();
						$horometros = $sheet->getCell("L".$row)->getValue();
						$unidad = $sheet->getCell("M".$row)->getValue();
						$suc = $sheet->getCell("N".$row)->getValue();				

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "almacen" => $almacen, "litros" => $litros, "importe" => $importe, "kilometro" => $kilometros, "horometro" => $horometros, "unidad" => $unidad, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

						$i = $i + 1;							
						
					}
				}

			}else if($idconce == 4){ //Entradas de Materia Prima

				for ($row = 7; $row <= $highestRow; $row++){
        			if(is_null($sheet->getCell("A".$row)->getValue()) == false){
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("B".$row)->getValue();
						$concepto = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();
						$razonsocial = $sheet->getCell("E".$row)->getValue();						
						$codigoproducto = $sheet->getCell("F".$row)->getValue();					
						$producto = $sheet->getCell("G".$row)->getValue();					
						$factor = $sheet->getCell("H".$row)->getValue();
						$almacen = $sheet->getCell("I".$row)->getValue();
						$cantidad = $sheet->getCell("J".$row)->getValue();
						$unidad = $sheet->getCell("K".$row)->getValue();
						$precio = $sheet->getCell("L".$row)->getValue();
						$suc = $sheet->getCell("M".$row)->getValue();
						
						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "factor" => $factor, "almacen" => $almacen, "cantidad" => $cantidad, "unidad" => $unidad, "precio" => $precio, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

						$i = $i + 1;
					}
				}

			}else if($idconce == 5){ //Salidas de Materia Prima

				for ($row = 7; $row <= $highestRow; $row++){
        			if(is_null($sheet->getCell("A".$row)->getValue()) == false){
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("B".$row)->getValue();
						$concepto = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();						
						$razonsocial = $sheet->getCell("E".$row)->getValue();
						$codigoproducto = $sheet->getCell("F".$row)->getValue();					
						$producto = $sheet->getCell("G".$row)->getValue();					
						$factor = $sheet->getCell("H".$row)->getValue();
						$almacen = $sheet->getCell("I".$row)->getValue();
						$cantidad = $sheet->getCell("J".$row)->getValue();
						$unidad = $sheet->getCell("K".$row)->getValue();
						$suc = $sheet->getCell("L".$row)->getValue();						
						
						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "almacen" => $almacen, "factor" => $factor, "cantidad" => $cantidad, "unidad" => $unidad, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

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

  			$idconce = $sheet->getCell("Z1")->getValue();
			//$concepto = $sheet->getCell("M2")->getValue();
  			//$codigo = $_POST['codigo'];
  			$i = 0;  			
			for ($row = 7; $row <= $highestRow; $row++){				
				if($idconce == 2){
					if(is_null($sheet->getCell("J".$row)->getValue()) == false){

						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("B".$row)->getValue();
						$concepto = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();
						$razonsocial = $sheet->getCell("E".$row)->getValue();
						$codigoproducto = $sheet->getCell("F".$row)->getValue();
						$producto = $sheet->getCell("G".$row)->getValue();
						$almacen = $sheet->getCell("H".$row)->getValue();
						$litros = $sheet->getCell("I".$row)->getValue();
						$importe = $sheet->getCell("J".$row)->getValue();
						$kilometros = $sheet->getCell("K".$row)->getValue();
						$horometros = $sheet->getCell("L".$row)->getValue();
						$unidad = $sheet->getCell("M".$row)->getValue();
						$suc = $sheet->getCell("N".$row)->getValue();

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "almacen" => $almacen, "litros" => $litros, "importe" => $importe, "kilometro" => $kilometros, "horometro" => $horometros, "unidad" => $unidad, "sucursal" => $suc);

						$i = $i + 1; 						

					}
				}else if($idconce == 3){
					if(is_null($sheet->getCell("K".$row)->getValue()) == false && is_null($sheet->getCell("N".$row)->getValue()) == false){

						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$folio = $sheet->getCell("B".$row)->getValue();
						$serie = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();
						$razonsocial = $sheet->getCell("E".$row)->getValue();
						$codigoconcepto = $sheet->getCell("F".$row)->getValue();						
						$concepto = $sheet->getCell("G".$row)->getValue();
						$codigoproducto = $sheet->getCell("H".$row)->getValue();
						$producto = $sheet->getCell("I".$row)->getValue();
						$cantidad = $sheet->getCell("J".$row)->getValue();
						$subtotal = $sheet->getCell("K".$row)->getValue();
						$descuento = $sheet->getCell("L".$row)->getValue();
						$iva = $sheet->getCell("M".$row)->getValue();
						$total = $sheet->getCell("N".$row)->getValue();
						$suc = $sheet->getCell("O".$row)->getValue();

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "folio" => $folio, "serie" => $serie, "cantidad" => $cantidad, "subtotal" => $subtotal, "descuento" => $descuento, "iva" => $iva, "total" => $total, "sucursal" => $suc);

						$i = $i + 1; 						

					}					
				}else if($idconce == 4){
					
        			if(is_null($sheet->getCell("A".$row)->getValue()) == false){
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("B".$row)->getValue();
						$concepto = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();
						$razonsocial = $sheet->getCell("E".$row)->getValue();						
						$codigoproducto = $sheet->getCell("F".$row)->getValue();					
						$producto = $sheet->getCell("G".$row)->getValue();					
						$factor = $sheet->getCell("H".$row)->getValue();
						$almacen = $sheet->getCell("I".$row)->getValue();
						$cantidad = $sheet->getCell("J".$row)->getValue();
						$unidad = $sheet->getCell("K".$row)->getValue();
						$precio = $sheet->getCell("L".$row)->getValue();
						$suc = $sheet->getCell("M".$row)->getValue();
						
						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "factor" => $factor, "almacen" => $almacen, "cantidad" => $cantidad, "unidad" => $unidad, "precio" => $precio, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

						$i = $i + 1;
					}
					
				}else if($idconce == 5){
					if(is_null($sheet->getCell("A".$row)->getValue()) == false){
						$fecha = $sheet->getCell("A".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("B".$row)->getValue();
						$concepto = $sheet->getCell("C".$row)->getValue();
						$rfc = $sheet->getCell("D".$row)->getValue();						
						$razonsocial = $sheet->getCell("E".$row)->getValue();
						$codigoproducto = $sheet->getCell("F".$row)->getValue();					
						$producto = $sheet->getCell("G".$row)->getValue();					
						$factor = $sheet->getCell("H".$row)->getValue();
						$almacen = $sheet->getCell("I".$row)->getValue();
						$cantidad = $sheet->getCell("J".$row)->getValue();
						$unidad = $sheet->getCell("K".$row)->getValue();
						$suc = $sheet->getCell("L".$row)->getValue();

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "concepto" => $concepto, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "producto" => $producto, "factor" => $factor, "almacen" => $almacen, "cantidad" => $cantidad, "unidad" => $unidad, "sucursal" => $suc);

						$i = $i + 1; 					
					}
				}

			}	

			//unlink("../submenus/archivostemp/".$NombreArchivo);

			echo json_encode($movtos);

  		}

  	}



?>