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

  	/*function NumeroDeSucursales($sheet, $highestRow){
		$i = 0;
		$n_suc = 0;
		$array_suc = [];
		for ($row = 0; $row <= $highestRow; $row++){				
			if(!in_array($sheet->getCell("O".$row)->getValue(), $array_suc)){
				$array_suc[$i] = $sheet->getCell("O".$row)->getValue();
				$n_suc = $n_suc + 1;
				$i = $i +1;
			}

		}  

		return $n_suc;
  	} */

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
  			//$suc_temp = "";
  			$foliotmp = "";
  			$fechatmp = "";
			$idconce = $sheet->getCell("Z1")->getValue();
			$concepto = $sheet->getCell("Z2")->getValue();

			//$numero_sucursales = NumeroDeSucursales($sheet, $highestRow);

			//for ($k=0; $k < $numero_sucursales; $k++) {

				if($idconce == 3){	//Remisiones

					for ($row = 7; $row <= $highestRow; $row++){				
						//$fecha = date($format = "d/m/y", PHPExcel_Shared_Date::ExcelToPHP($sheet->getCell("B".$row)->getValue()));
						if(is_null($sheet->getCell("M".$row)->getValue()) == false && is_null($sheet->getCell("P".$row)->getValue()) == false && $sheet->getCell("Z".$row)->getValue() != "A"){
							
							$suc = $sheet->getCell("A".$row)->getValue();	
							$fecha = $sheet->getCell("B".$row)->getValue();
							$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
							$fecha = date("Y-m-d", $fecha);
							$folio = $sheet->getCell("C".$row)->getValue();
							$serie = $sheet->getCell("D".$row)->getValue();
							$codcliprov = $sheet->getCell("E".$row)->getValue();
							$rfc = $sheet->getCell("F".$row)->getValue();
							$razonsocial = $sheet->getCell("G".$row)->getValue();
							$codigoconcepto = $sheet->getCell("H".$row)->getValue();						
							$concepto = $sheet->getCell("I".$row)->getValue();
							$codigoproducto = $sheet->getCell("J".$row)->getValue();
							$producto = $sheet->getCell("K".$row)->getValue();
							$cantidad = $sheet->getCell("L".$row)->getValue();
							$subtotal = $sheet->getCell("M".$row)->getValue();
							$descuento = $sheet->getCell("N".$row)->getValue();
							$iva = $sheet->getCell("O".$row)->getCalculatedValue();
							$total = $sheet->getCell("P".$row)->getCalculatedValue();
												

							$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "folio" => $folio, "serie" => $serie, "cantidad" => $cantidad, "subtotal" => $subtotal, "descuento" => $descuento, "iva" => $iva, "total" => $total, "sucursal" => $suc ,"idconce" => $idconce, "estatus" => "", "codigo" => "");

							$TotalNeto = 0; 
							$TotalDesc = 0;
							$TotalIVA = 0;
							$TotalDoc = 0;
							$Cantidad = 0;

							$foliotmp = $folio;
							$fechatmp = $fecha;	
							$suctemp = $suc;				

							
							for ($numf = 7; $numf <= $highestRow; $numf++){ //recorremos los movimientos y acumulamos si cumplen los filtros
							   if(is_null($sheet->getCell("P".$numf)->getValue()) == false && is_null($sheet->getCell("M".$numf)->getValue()) == false && $sheet->getCell("Z".$numf)->getValue() != "A"){					   		
									$fechamov = $sheet->getCell("B".$numf)->getValue();
									$fechamov = PHPExcel_Shared_Date::ExcelToPHP($fechamov);
									$fechamov = date("Y-m-d", $fechamov);					   		
									
									if(ValidarFolio($sheet->getCell("C".$numf)->getValue()) == true){
										if($sheet->getCell("C".$numf)->getValue() == $foliotmp && $fechamov == $fechatmp && $sheet->getCell("A".$numf)->getValue() == $suctemp){

											$Cantidad = $Cantidad + $sheet->getCell("L".$row)->getValue();
											$TotalNeto = $TotalNeto + $sheet->getCell("M".$numf)->getValue();
											$TotalDesc = $TotalDesc + $sheet->getCell("N".$numf)->getValue();
											$TotalIVA = $TotalIVA + $sheet->getCell("O".$numf)->getCalculatedValue();
											$TotalDoc = $TotalDoc + $sheet->getCell("P".$numf)->getCalculatedValue();
											$movtos[$i]["cantidad"] = $Cantidad;
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
						if(is_null($sheet->getCell("B".$row)->getValue()) == false){				
							$suc = $sheet->getCell("A".$row)->getValue();	
							$fecha = $sheet->getCell("B".$row)->getValue();
							$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
							$fecha = date("Y-m-d", $fecha);
							$codigoconcepto = $sheet->getCell("C".$row)->getValue();
							$concepto = $sheet->getCell("D".$row)->getValue();
							$codcliprov = $sheet->getCell("E".$row)->getValue();
							$rfc = $sheet->getCell("F".$row)->getValue();
							$razonsocial = $sheet->getCell("G".$row)->getValue();
							$codigoproducto = $sheet->getCell("H".$row)->getValue();
							$producto = $sheet->getCell("I".$row)->getValue();
							$almacen = $sheet->getCell("J".$row)->getValue();
							$litros = $sheet->getCell("K".$row)->getValue();
							$importe = $sheet->getCell("L".$row)->getValue();
							$kilometros = $sheet->getCell("M".$row)->getValue();
							$horometros = $sheet->getCell("N".$row)->getValue();
							$unidad = $sheet->getCell("O".$row)->getValue();										

							$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "almacen" => $almacen, "cantidad" => $litros, "total" => $importe, "kilometro" => $kilometros, "horometro" => $horometros, "unidad" => $unidad, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

							$i = $i + 1;							
							
						}else{
							break;
						}
					}

				}else if($idconce == 4){ //Entradas de Materia Prima

					for ($row = 7; $row <= $highestRow; $row++){
	        			if(is_null($sheet->getCell("B".$row)->getValue()) == false){
							$suc = $sheet->getCell("A".$row)->getValue();
							$fecha = $sheet->getCell("B".$row)->getValue();
							$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
							$fecha = date("Y-m-d", $fecha);
							$codigoconcepto = $sheet->getCell("C".$row)->getValue();
							$concepto = $sheet->getCell("D".$row)->getValue();
							$codcliprov = $sheet->getCell("E".$row)->getValue();
							$rfc = $sheet->getCell("F".$row)->getValue();
							$razonsocial = $sheet->getCell("G".$row)->getValue();						
							$codigoproducto = $sheet->getCell("H".$row)->getValue();					
							$producto = $sheet->getCell("I".$row)->getValue();					
							$factor = $sheet->getCell("J".$row)->getValue();
							$almacen = $sheet->getCell("K".$row)->getValue();
							$cantidad = $sheet->getCell("L".$row)->getValue();
							$unidad = $sheet->getCell("M".$row)->getValue();
							$precio = $sheet->getCell("N".$row)->getValue();							
							
							$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "factor" => $factor, "almacen" => $almacen, "cantidad" => $cantidad, "unidad" => $unidad, "total" => $precio, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

							$i = $i + 1;
						}else{
							break;
						}
					}

				}else if($idconce == 5){ //Salidas de Materia Prima

					for ($row = 7; $row <= $highestRow; $row++){						
	        			if(is_null($sheet->getCell("B".$row)->getValue()) == false){
							$suc = $sheet->getCell("A".$row)->getValue();
							$fecha = $sheet->getCell("B".$row)->getValue();
							$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
							$fecha = date("Y-m-d", $fecha);
							$codigoconcepto = $sheet->getCell("C".$row)->getValue();
							$concepto = $sheet->getCell("D".$row)->getValue();
							$codcliprov = $sheet->getCell("E".$row)->getValue();
							$rfc = $sheet->getCell("F".$row)->getValue();						
							$razonsocial = $sheet->getCell("G".$row)->getValue();
							$codigoproducto = $sheet->getCell("H".$row)->getValue();					
							$producto = $sheet->getCell("I".$row)->getValue();					
							$factor = $sheet->getCell("J".$row)->getValue();
							$almacen = $sheet->getCell("K".$row)->getValue();
							$cantidad = $sheet->getCell("L".$row)->getValue();
							$unidad = $sheet->getCell("M".$row)->getValue();							
							
							$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "almacen" => $almacen, "factor" => $factor, "cantidad" => $cantidad, "unidad" => $unidad, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

							$i = $i + 1;
						}else{
							break;
						}
					}

				}			
		//	}

			if($i == 0){
				$movtos[0] = array("fecha" => "Vacio", "codprod" => "Vacio", "cantidad" => "Vacio", "neto" => "Vacio", "descuento" => "Vacio", "iva" => "Vacio", "total" => "Vacio");
			}
			
			echo json_encode($movtos);


//VALIDACION TIPO 3 -> REGRESA UN ARREGLO CON LOS MOVIMIENTOS.
		}else if($_POST['validacion']==3){

			//$numero_sucursales = NumeroDeSucursales($sheet, $highestRow);

  			$idconce = $sheet->getCell("Z1")->getValue();

  			$i = 0;  			
			for ($row = 7; $row <= $highestRow; $row++){				
				if($idconce == 2){
					if(is_null($sheet->getCell("L".$row)->getValue()) == false){
						$suc = $sheet->getCell("A".$row)->getValue();
						$fecha = $sheet->getCell("B".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("C".$row)->getValue();
						$concepto = $sheet->getCell("D".$row)->getValue();
						$codcliprov = $sheet->getCell("E".$row)->getValue();
						$rfc = $sheet->getCell("F".$row)->getValue();
						$razonsocial = $sheet->getCell("G".$row)->getValue();
						$codigoproducto = $sheet->getCell("H".$row)->getValue();
						$producto = $sheet->getCell("I".$row)->getValue();
						$almacen = $sheet->getCell("J".$row)->getValue();
						$litros = $sheet->getCell("K".$row)->getValue();
						$importe = $sheet->getCell("L".$row)->getValue();
						$kilometros = $sheet->getCell("M".$row)->getValue();
						$horometros = $sheet->getCell("N".$row)->getValue();
						$unidad = $sheet->getCell("O".$row)->getValue();						

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "almacen" => $almacen, "cantidad" => $litros, "total" => $importe, "kilometro" => $kilometros, "horometro" => $horometros, "unidad" => $unidad, "sucursal" => $suc);

						$i = $i + 1; 						

					}else{
						break;
					}
				}else if($idconce == 3){
					if(is_null($sheet->getCell("M".$row)->getValue()) == false && is_null($sheet->getCell("P".$row)->getValue()) == false){
						$suc = $sheet->getCell("A".$row)->getValue();
						$fecha = $sheet->getCell("B".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$folio = $sheet->getCell("C".$row)->getValue();
						$serie = $sheet->getCell("D".$row)->getValue();
						$codcliprov = $sheet->getCell("E".$row)->getValue();
						$rfc = $sheet->getCell("F".$row)->getValue();
						$razonsocial = $sheet->getCell("G".$row)->getValue();
						$codigoconcepto = $sheet->getCell("H".$row)->getValue();						
						$concepto = $sheet->getCell("I".$row)->getValue();
						$codigoproducto = $sheet->getCell("J".$row)->getValue();
						$producto = $sheet->getCell("K".$row)->getValue();
						$cantidad = $sheet->getCell("L".$row)->getValue();
						$subtotal = $sheet->getCell("M".$row)->getValue();
						$descuento = $sheet->getCell("N".$row)->getValue();
						$iva = $sheet->getCell("O".$row)->getCalculatedValue();
						$total = $sheet->getCell("P".$row)->getCalculatedValue();
						

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "folio" => $folio, "serie" => $serie, "cantidad" => $cantidad, "subtotal" => $subtotal, "descuento" => $descuento, "iva" => $iva, "total" => $total, "almacen" => "" , "unidad" => "" , "horometro" => "", "kilometro" => "", "sucursal" => $suc);

						$i = $i + 1; 						

					}else{
						break;
					}					
				}else if($idconce == 4){
					
        			if(is_null($sheet->getCell("B".$row)->getValue()) == false){
						$suc = $sheet->getCell("A".$row)->getValue();
						$fecha = $sheet->getCell("B".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("C".$row)->getValue();
						$concepto = $sheet->getCell("D".$row)->getValue();
						$codcliprov = $sheet->getCell("E".$row)->getValue();
						$rfc = $sheet->getCell("F".$row)->getValue();
						$razonsocial = $sheet->getCell("G".$row)->getValue();						
						$codigoproducto = $sheet->getCell("H".$row)->getValue();					
						$producto = $sheet->getCell("I".$row)->getValue();					
						$factor = $sheet->getCell("J".$row)->getValue();
						$almacen = $sheet->getCell("K".$row)->getValue();
						$cantidad = $sheet->getCell("L".$row)->getValue();
						$unidad = $sheet->getCell("M".$row)->getValue();
						$precio = $sheet->getCell("N".$row)->getValue();						
						
						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "factor" => $factor, "almacen" => $almacen, "cantidad" => $cantidad, "unidad" => $unidad, "total" => $precio, "sucursal" => $suc, "idconce" => $idconce, "estatus" => "", "codigo" => "");

						$i = $i + 1;
					}else{
						break;
					}
					
				}else if($idconce == 5){
					if(is_null($sheet->getCell("B".$row)->getValue()) == false){
						$suc = $sheet->getCell("A".$row)->getValue();
						$fecha = $sheet->getCell("B".$row)->getValue();
						$fecha = PHPExcel_Shared_Date::ExcelToPHP($fecha);
						$fecha = date("Y-m-d", $fecha);
						$codigoconcepto = $sheet->getCell("C".$row)->getValue();
						$concepto = $sheet->getCell("D".$row)->getValue();
						$codcliprov = $sheet->getCell("E".$row)->getValue();
						$rfc = $sheet->getCell("F".$row)->getValue();						
						$razonsocial = $sheet->getCell("G".$row)->getValue();
						$codigoproducto = $sheet->getCell("H".$row)->getValue();					
						$producto = $sheet->getCell("I".$row)->getValue();					
						$factor = $sheet->getCell("J".$row)->getValue();
						$almacen = $sheet->getCell("K".$row)->getValue();
						$cantidad = $sheet->getCell("L".$row)->getValue();
						$unidad = $sheet->getCell("M".$row)->getValue();
						

						$movtos[$i] = array("fecha" => $fecha, "codigoconcepto" => $codigoconcepto, "nombreconcepto" => $concepto, "codigocliprov" => $codcliprov, "rfc" => $rfc, "razonsocial" => $razonsocial, "codigoproducto" => $codigoproducto, "nombreproducto" => $producto, "factor" => $factor, "almacen" => $almacen, "cantidad" => $cantidad, "unidad" => $unidad, "sucursal" => $suc);

						$i = $i + 1; 					
					}else{
						break;
					}
				}

			}	

			//unlink("../submenus/archivostemp/".$NombreArchivo);

			echo json_encode($movtos);

  		}

  	}



?>