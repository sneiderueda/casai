<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    </head>

    <?php
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    /**
     * Description of mg_otPresupuesto
     *
     * @author user
     */
    require_once '../../components/phpexcel/Classes/PHPExcel.php';
    require_once '../0connection/BD_config.php';
    require_once '../0connection/connection.php';
    require_once '../0connection/BD.php';

    class mg_otPresupuesto {

        public function Datapresupuesto() {
            $obj_bd = new BD();
            // Cargando el archivo y la hoja que vamos a importar
            $archivo = "../../components/migracion/OT17-013.xlsx";
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
            $total_sheets = $objPHPExcel->getSheetCount();
            var_dump($total_sheets);
            for ($z = 0; $z < $total_sheets; $z++) {
                if ($z % 2 == 0 || $z == 0) {
                    $sheet = $z;
                    //Lectura de resumen
                    $numrows = $objPHPExcel->setActiveSheetIndex($z)->getHighestRow();
$temp=$z+1;
                    $numrowsOT = $objPHPExcel->setActiveSheetIndex($z+1)->getHighestRow();
                    $total_sheets = $objPHPExcel->getSheetCount();
                    $matrizActasNum = array();
                    $ivaFactura = "";
                    $valorTotal = 0;
                    $valorFacturadoArray = array();
                    $porcentajesActualArray = array();
                    $matrizEncabeValor = array();
                    $matrizValorPend = array();
                    $matrizE = array();
                    $matrizEfinal = array();
                    $matrizB = array();
                    $matrizBfinal = array();
                    $matrizJ = array();
                    $matrizJfinal = array();
                    $matrizJbaremo = array();
                    $matrizJbaremoitem = array();
                    //Lectura de columna numero de Actas
                    $contB = 1;
                    for ($i = 28; $i <= $numrows; $i++) {
                        $nombre = $objPHPExcel->getSheet($sheet)->getCell('B' . $i)->getCalculatedValue();
                        if ($nombre != "" && trim($nombre) != "TOTAL") {
                            $matrizActasNum[$contB] = $contB;
                            //Valor facturado array
                            $valorFacturadoArray[$contB] = $objPHPExcel->getSheet($sheet)->getCell('C' . $i)->getCalculatedValue();
                            //Porcentaje Actual
                            if ($contB == 1) {
                                $porcentajesActualArray[$contB] = round($objPHPExcel->getSheet($sheet)->getCell('E' . $i)->getCalculatedValue() * 100);
                            } else {
                                $porcentajesActualArray[$contB] = $porcentajesActualArray[$contB - 1] + round($objPHPExcel->getSheet($sheet)->getCell('E' . $i)->getCalculatedValue() * 100);
                            }

                            $contB++;
                        }
                        if (trim($nombre) == "TOTAL") {
                            $valorTotal = $objPHPExcel->getSheet($sheet)->getCell('C' . $i)->getCalculatedValue();
                        }
                    }
                    //Lectura de iva 
                    for ($i = 14; $i <= $numrowsOT; $i++) {
                        $nombre = $objPHPExcel->getSheet($sheet)->getCell('K' . $i)->getCalculatedValue();
                        if ($nombre == "IVA 19%") {
                            //iva factura
                            $ivaFactura = round($objPHPExcel->getSheet($sheet)->getCell('L' . $i)->getCalculatedValue());
                            $totalFactura = round($objPHPExcel->getSheet($sheet)->getCell('L' . ($i + 1))->getCalculatedValue());
                            $totalFacturaH = round($objPHPExcel->getSheet($sheet)->getCell('H' . ($i + 1))->getCalculatedValue());
                            $totalFacturaI = round($objPHPExcel->getSheet($sheet)->getCell('I' . ($i + 1))->getCalculatedValue());
                        }
                    }

                    $totalFactura = $totalFacturaH - $totalFactura;
                    //porcentaje facturado
                    $porcentajeFacturado = 100 - (round(($totalFactura * 100) / $totalFacturaH));
                    //porcentaje pendiente
                    $porcentajePendiente = round(($totalFactura * 100) / $totalFacturaH);
                    //Valor pendiente
                    $columna = 11;
                    for ($i = 1; $i <= count($matrizActasNum); $i++) {
                        $matrizEncabeValor[$i] = $objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($columna, 13)->getCalculatedValue();
                        if (strpos($matrizEncabeValor[$i], '2018') !== false) {
                            $matrizValorPend[$i] = $totalFacturaI - $valorFacturadoArray[$i];
                        } else {
                            $matrizValorPend[$i] = $totalFacturaH - $valorFacturadoArray[$i];
                        }
                        $columna = $columna + 3;
                    }

                    //Lectura de ot
                    $OT = $objPHPExcel->getSheet($sheet)->getCell('A10')->getCalculatedValue();
                    $arrayOT = explode(":", $OT);
                    $OT = trim($arrayOT[0]) . trim($arrayOT[1]);

                    //Insercion de la factura
                    for ($i = 1; $i <= count($matrizValorPend); $i++) {
                        $sql = "CALL CargueFactura(" . $matrizActasNum[$i] . ",NOW(),NOW()," . $ivaFactura . "," . $porcentajesActualArray[$i] . "," . $porcentajeFacturado . "," . $porcentajePendiente . "," . $valorFacturadoArray[$i] . "," . $matrizValorPend[$i] . "," . $valorTotal . ",'" . $OT . "');";
                        //$resultado = $obj_bd->EjecutaConsulta($sql);
                        var_dump($sql );
                    }

                    //Desde aqui se comienza a llenar el detalle de la factura
                    $arrayCantidad = array();
                    $arrayValor = array();
                    $arrayPorcentaje = array();
                    $matrizC = array();
                    $matrizCfinal = array();
                    $matrizDfinal = array();
                    $matrizD = array();
                    $countAux = 1;
                    $columnaD = 10;
                    $fila = 14;
                    $nomArea = "";
                    $var = "";
                    $nomArea = "";
                    $actasRelacion = array();

                    $presupuestoNomb = "";
                    //Lectura de nombre del presupuesto
                    $nomSheets = $objPHPExcel->getSheetNames();
                    $proyectoArray = explode(" ", $nomSheets[1]);
                    //var_dump($proyectoArray);
                    for ($i = 0; $i < count($proyectoArray); $i++) {
                        if ($i >= 2) {
                            $presupuestoNomb .= $proyectoArray[$i] . " ";
                        }
                    }
                    $presupuestoNomb = trim($presupuestoNomb);
                    //var_dump($presupuestoNomb);

                    $o = 1;
                    //Lectura columna C         
                    for ($i = 14; $i <= ($numrows); $i++) {
                        $nombreB = $objPHPExcel->getSheet($sheet)->getCell('C' . $i)->getCalculatedValue();
                        if ($nombreB != "") {
                            $var = $var . $nombreB . "|";
                        } else {
                            $matrizC[$o] = $var;
                            $o++;
                            $var = "";
                        }
                    }
                    for ($i = 1; $i <= count($matrizC); $i++) {
                        if ($matrizC[$i] != "") {
                            $matrizCfinal[$i] = $matrizC[$i];
                        }
                    }
                    //Lectura de la area 
                    if (count($matrizC) > 0) {
                        $nombre = explode(" ", $matrizC[1]);
                        $nomArea = $nombre[1];
                    }

                    //Lectura columna C         
                    for ($i = 14; $i <= ($numrows + 1); $i++) {
                        $nombreB = $objPHPExcel->getSheet($sheet)->getCell('C' . $i)->getCalculatedValue();
                        if ($nombreB != "") {
                            $var = $var . $nombreB . "|";
                        } else {
                            $matrizC[$o] = $var;
                            $o++;
                            $var = "";
                        }
                    }
                    for ($i = 1; $i <= count($matrizC); $i++) {
                        if ($matrizC[$i] != "") {
                            $matrizCfinal[$i] = $matrizC[$i];
                        }
                    }
                    $q = 1;
                    $var = "";
                    $auxConRegC = 0;
                    //Lectura columna E      
                    for ($i = 14; $i <= $numrows + 1; $i++) {
                        $nombreE = (string) $objPHPExcel->getSheet($sheet)->getCell('E' . $i)->getCalculatedValue();

                        if ($nombreE != "") {
                            $auxConRegC++;
                            $var = $var . $nombreE . "|";
                        } else if ($nombreE == "") {
                            $matrizE[$q] = $auxConRegC++ . "|" . $var;
                            $q++;
                            $var = "";
                            $auxConRegC = 0;
                        }
                    }
                    for ($i = 1; $i <= count($matrizE); $i++) {
                        if ($matrizE[$i] != "") {
                            $matrizEfinal[$i] = $matrizE[$i];
                        }
                    }

                    //Lectura de combinacion de celdas            
                    for ($i = 0; $i <= count($matrizCfinal); $i++) {
                        if ($matrizE[$i] != 0) {
                            $array = explode("|", $matrizE[$i]);
                            $matrizCeldaC[$i] = ((int) $array[0]) + 1;
                        }
                    }
                    $varPruebas = 14;
                    $matrizPrueba = array();
                    for ($i = 1; $i <= count($matrizCeldaC); $i++) {
                        $matrizPrueba[$i] = $varPruebas;
                        $varPruebas = $varPruebas + $matrizCeldaC[$i];
                        $matrizPrueba[$i] = $matrizPrueba[$i] . "-" . ($varPruebas - 1);
                    }


                    //Lectura de B
                    $contBF = 1;
                    for ($i = 14; $i <= $numrows; $i++) {
                        $nombre = (string) $objPHPExcel->getSheet($sheet)->getCell('A' . $i)->getCalculatedValue();
                        if ($nombre != "") {
                            $matrizB[$contBF] = $nombre;
                            $contBF++;
                        }
                    }
                    $auxB = 1;
                    for ($i = 1; $i <= count($matrizCeldaC); $i++) {
                        $iterSub = $matrizCeldaC[$i];
                        $matrizBfinal[$i] = $matrizB[$auxB];
                        $auxB = $auxB + $iterSub;
                    }


                    //Array de baremo
                    $contBar = 1;
                    for ($i = 1; $i <= count($matrizBfinal); $i++) {
                        $nombre = explode(" ", $matrizBfinal[$i]);
                        $nombre1 = explode("-", (string) $nombre[0]);
                        $matrizJbaremo[$contBar] = (string) $nombre1[0];
                        $matrizJbaremoitem[$contBar] = (string) $nombre1[1];
                        $contBar++;
                    }
                    $matrizModulo = array();
                    //For que recorre las columnas
                    for ($i = 1; $i <= count($matrizActasNum); $i++) {
                        //For que recorre las filas
                        for ($j = $fila; $j <= $numrows; $j++) {
                            $nombre = strval($objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($columnaD, $j)->getCalculatedValue());
                            if (trim($nombre) != "SUBTOTAL") {
                                if ($nombre != "" && $nombre != "0") {
                                    $arrayCantidad[$countAux] = $objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($columnaD, $j)->getCalculatedValue();
                                    $arrayValor[$countAux] = $objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($columnaD + 1, $j)->getCalculatedValue();
                                    $arrayPorcentaje[$countAux] = round(($objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($columnaD + 2, $j)->getCalculatedValue()) * 100);
                                    $matrizDfinal[$countAux] = $objPHPExcel->getSheet($sheet)->getCell('D' . $j)->getCalculatedValue();

                                    for ($q = 1; $q <= count($matrizPrueba); $q++) {
                                        $arrayOT = explode("-", $matrizPrueba[$q]);
                                        //var_dump($arrayOT);
                                        if ($j >= $arrayOT[0] && $j <= $arrayOT[1]) {
                                            $matrizModulo[$countAux] = ($matrizB[$q]);
                                        }
                                    }

                                    $actasRelacion[$countAux] = $i;
                                    $countAux = $countAux + 1;
                                }
                            } else {
                                break;
                            }
                        }

                        $columnaD = $columnaD + 3;
                    }

                    //Insercion del detalle de factura
                    for ($i = 1; $i <= count($arrayPorcentaje); $i++) {
                        $sql = "call CargueDetalleFactura('" . $arrayPorcentaje[$i] . "',"
                                . "'" . $arrayCantidad[$i] . "','" . $arrayValor[$i] . "',"
                                . "'" . quitar_tildes($presupuestoNomb) . "',"
                                . "" . $actasRelacion[$i] . ","
                                . "'" . $nomArea . "',"
                                . "'" . $OT . "',"
                                . "'1',"
                                . "'" . $matrizDfinal[$i] . "',"
                                . "'" . quitar_tildes($matrizModulo[$i]) . "');";
                        //$resultado = $obj_bd->EjecutaConsulta($sql);
                        var_dump($sql);
                    }
                }
            }
        }

    }

    function quitar_tildes($cadena) {
        $no_permitidas = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "À", "Ã", "Ì", "Ò", "Ù", "Ã™", "Ã ", "Ã¨", "Ã¬", "Ã²", "Ã¹", "ç", "Ç", "Ã¢", "ê", "Ã®", "Ã´", "Ã»", "Ã‚", "ÃŠ", "ÃŽ", "Ã”", "Ã›", "ü", "Ã¶", "Ã–", "Ã¯", "Ã¤", "«", "Ò", "Ã", "Ã„", "Ã‹");
        $permitidas = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "A", "E", "I", "O", "U", "a", "e", "i", "o", "u", "c", "C", "a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "u", "o", "O", "i", "a", "e", "U", "I", "A", "E");
        $texto = str_replace($no_permitidas, $permitidas, $cadena);
        return $texto;
    }

    $class_xls = new mg_otPresupuesto();
    echo '<pre> salida ';
    $class_xls->Datapresupuesto();

    echo '</pre>';
    ?>
</html>