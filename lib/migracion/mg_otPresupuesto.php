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



            // Cargando el archivo y la hoja que vamos a importar
            $archivo = "../../components/migracion/OT17-013.xlsx";
            $objPHPExcel = PHPExcel_IOFactory::load($archivo);
            $total_sheets = $objPHPExcel->getSheetCount();
            for ($z = 0; $z < $total_sheets; $z++) {
                
                if (!($z %2==0)) {
                    $sheet = $z;
                    $objPHPExcel->setActiveSheetIndex($z);
                    $OT = explode(": ", $objPHPExcel->getActiveSheet($z)->getCell('A10')->getCalculatedValue());
                    
                    $matrizCeldaC = array();
                    $matriz = array();
                    $matrizB = array();
                    $matrizBfinal = array();
                    $matrizC = array();
                    $matrizCfinal = array();
                    $matrizD = array();
                    $matrizDfinal = array();
                    $matrizE = array();
                    $matrizEfinal = array();
                    $matrizI = array();
                    $matrizJ = array();
                    $matrizJfinal = array();
                    $matrizJbaremo = array();
                    $matrizJbaremoitem = array();
                    $matrizAreas = array();
                    $indice = 1;
                    $objPHPExcel->setActiveSheetIndex($z);
                    $numrows = $objPHPExcel->setActiveSheetIndex($z)->getHighestRow();
                    $presupuestoNomb = "";
                    $var = "";
                    $subestacion1 = "";
                    $subestacion2 = "";
                    $nomArea = "";
                    $detPresualcance = "";
                    $obj_bd = new BD();
                    $porcIncremento = 0;

                    //Nombre de contratista
                    $nombreContratista = "AC ENERGY";

                    //Lectura de ot
                    $OT = $objPHPExcel->getSheet($sheet)->getCell('A10')->getCalculatedValue();
                    $arrayOT = explode(":", $OT);
                    $OT = trim($arrayOT[0]) . trim($arrayOT[1]);

                    //Lectura de nombre del presupuesto
                    $nomSheets = $objPHPExcel->getSheetNames();
                    $proyectoArray = explode(" ", $nomSheets[$z]);
                    //var_dump($proyectoArray);
                    
                    for ($i = 0; $i < count($proyectoArray); $i++) {
                        if ($i >= 2) {
                            $presupuestoNomb .= $proyectoArray[$i] . " ";
                        }
                    }

                    //Lectura de la subestacion       
                    $proyectoArray = explode(" ", $nomSheets[$z]);
                    //var_dump($proyectoArray);
                    $subestacion1 = $proyectoArray[1];
                    if (count($proyectoArray) > 3) {
                        $subestacion2 = $proyectoArray[3];
                    }


                    //Lectura de numero de contrato
                    $noContrato = $objPHPExcel->getSheet($sheet)->getCell('A5')->getCalculatedValue();
                    $proyectoContrato = explode(" ", $noContrato);
                    $noContrato = $proyectoContrato[2];



                    //Lectura de columna A
                    $contA = 1;
                    for ($i = 14; $i <= $numrows; $i++) {
                        $nombre = $objPHPExcel->getSheet($sheet)->getCell('A' . $i)->getCalculatedValue();
                        if ($nombre == "Entregado por:") {
                            Break;
                        }
                        if ($nombre != "") {
                            $matriz[$contA] = $nombre;
                            $contA++;
                        }
                    }

                    $o = 1;

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


                    $p = 1;
                    $var = "";
                    //Lectura columna D  
                    for ($i = 14; $i <= $numrows + 1; $i++) {
                        $nombreD = $objPHPExcel->getSheet($sheet)->getCell('D' . $i)->getCalculatedValue();
                        //var_dump($nombreD. "<br><br>");            
                        if ($nombreD != "") {
                            if (strlen(stristr($nombreD, 'Subtotal')) > 0) {
                                //var_dump($var. "<br><br>");
                                $matrizD[$p] = $var;
                                $p++;
                                $var = "";
                            } else {
                                //var_dump($nombreD);
                                $var = $var . $nombreD . "|";
                            }
                        }
                    }

                    //var_dump($matrizD);
                    for ($i = 1; $i <= count($matrizD); $i++) {
                        if ($matrizD[$i] != "") {
                            $matrizDfinal[$i] = $matrizD[$i];
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
                    $matrizExpPorcentaje = array();
                    $auxPor = '';
                    //Lectura de porcentajes           
                    for ($i = 1; $i <= count($matrizEfinal); $i++) {
                        $array = explode("|", $matrizEfinal[$i]);
                        for ($j = 1; $j <= $array[0]; $j++) {
                            $auxPor = $auxPor . $array[$j] . "|";
                        }
                        $matrizExpPorcentaje[$i] = $auxPor;
                        $auxPor = '';
                    }



                    //Lectura de combinacion de celdas            
                    for ($i = 0; $i <= count($matrizCfinal); $i++) {
                        if ($matrizE[$i] != 0) {
                            $array = explode("|", $matrizE[$i]);
                            $matrizCeldaC[$i] = ((int) $array[0]) + 1;
                        }
                    }

                    //Lectura de J
                    $contJF = 1;
                    for ($i = 14; $i <= $numrows; $i++) {
                        $nombre = (string) $objPHPExcel->getSheet($sheet)->getCell('J' . $i)->getCalculatedValue();
                        $matrizJ[$contJF] = $nombre;
                        $contJF++;
                    }

                    $aux = 1;
                    for ($i = 1; $i <= count($matrizCeldaC); $i++) {
                        $iterSub = $matrizCeldaC[$i];
                        $matrizJfinal[$i] = $matrizJ[$aux];
                        $aux = $aux + $iterSub;
                    }
                    //Lectura de B
                    $contBF = 1;
                    for ($i = 14; $i <= $numrows; $i++) {
                        $nombre = (string) $objPHPExcel->getSheet($sheet)->getCell('B' . $i)->getCalculatedValue();
                        $matrizB[$contBF] = $nombre;
                        $contBF++;
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


                    //Lectura de la area 
                    if (count($matrizC) > 0) {
                        $nombre = explode(" ", $matrizC[1]);
                        $nomArea = $nombre[1];
                    }

                    //Matriz con nombre de area 
                    for ($i = 1; $i <= count($matrizCfinal); $i++) {
                        $nombre = explode(" ", $matrizCfinal[$i]);
                        $matrizAreas[$i] = $nombre[1];
                    }




                    //Lectura del detalle presupuesto alcance
                    for ($i = 1; $i <= count($matrizJfinal); $i++) {
                        $detPresualcance .= $matriz[$i] . " " . $matrizJfinal[$i] . " ";
                    }

                    $detValIncremen = 0;
                    $detValIncremen19 = 0;
                    $detValIncremen3 = 0;
                    $presuTotal = 0;

                    //Lectura de porcentaje incremento

                    for ($i = 14; $i <= $numrows + 14; $i++) {
                        $nombre = (string) $objPHPExcel->getSheet($sheet)->getCell('F' . $i)->getCalculatedValue();
                        //var_dump($nombre);
                        if ($nombre == "UBICACIÓN 3%") {
                            if (($objPHPExcel->getSheet($sheet)->getCell('I' . $i)->getCalculatedValue()) > 0) {
                                $porcIncremento = $porcIncremento + 3;
                                $detValIncremen3 = $objPHPExcel->getSheet($sheet)->getCell('I' . $i)->getCalculatedValue();
                            }
                        }
                        if ($nombre == "IVA 19%") {
                            if (($objPHPExcel->getSheet($sheet)->getCell('I' . $i)->getCalculatedValue()) > 0) {
                                $porcIncremento = $porcIncremento + 19;
                                $detValIncremen19 = $objPHPExcel->getSheet($sheet)->getCell('I' . $i)->getCalculatedValue();
                            }
                        }
                        if (TRIM($nombre == "TOTAL ")) {
                            $presuTotal = $objPHPExcel->getSheet($sheet)->getCell('I' . $i)->getCalculatedValue();
                        }
                    }
                    if ($detValIncremen19 > 0) {
                        $detValIncremen = $detValIncremen19;
                    } else {
                        $detValIncremen = $detValIncremen3;
                    }
                    $sheetDataAux = array();
                    $idxAux = 0;
                    $sheetData = $objPHPExcel->getSheet($sheet)->toArray(null, true, true, true);
                    for ($i = 1; $i <= count($sheetData); $i++) {
                        $sheetDataAux = $sheetData[$i];
                        if (in_array("CÓDIGO GOM", $sheetDataAux)) {
                            $idxAux = $i;
                        }
                    }
                    $sheetDataAux = $sheetData[$idxAux];
                    $columna = 1;

                    foreach ($sheetDataAux as $key => $value) {
                        IF ($value == "CÓDIGO GOM") {
                            $mykey = $columna;
                        }
                        $columna++;
                    }

                    $codigoGom = $objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($mykey, $idxAux)->getCalculatedValue();
                    $ordenPEP = $objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($mykey, $idxAux + 1)->getCalculatedValue();
                    $ordenPresup = $objPHPExcel->getSheet($sheet)->getCellByColumnAndRow($mykey, $idxAux + 2)->getCalculatedValue();


                    //Lectura de I totales
                    $contI = 1;
                    for ($i = 14; $i <= $numrows; $i++) {
                        $nombre = (string) $objPHPExcel->getSheet($sheet)->getCell('I' . $i)->getCalculatedValue();
                        if ($nombre != "") {
                            $matrizI[$contI] = $nombre;
                            $contI++;
                        }
                    }
                    $contAuxI = 1;
                    for ($i = 1; $i <= count($matrizCeldaC); $i++) {
                        $nombre = "";
                        for ($j = 1; $j <= $matrizCeldaC[$i]; $j++) {
                            if ($j < $matrizCeldaC[$i]) {
                                $nombre = $nombre . $matrizI[$contAuxI] . "|";
                            }
                            $contAuxI++;
                        }
                        $matrizIFinal[$i] = $nombre;
                    }


                    $sql = "CALL  MigracionPresupuesto ('" . $OT . "','" . quitar_tildes($presupuestoNomb) . "','" . quitar_tildes($subestacion1) . "',"
                            . "'" . $noContrato . "','" . $nomArea . "','" . quitar_tildes($detPresualcance) . "',null,null,null,'" . $porcIncremento . "',null,'" . $presuTotal . "','" . $detValIncremen . "','AC ENERGY1',null,null,null,'" . $codigoGom . "',null,'" . $ordenPresup . "','" . $ordenPEP . "')";
                    //var_dump($sql);
                    $resultado = $obj_bd->EjecutaConsulta($sql);
                    if ($resultado == "1") {
                        //Insercion del presupuesto
                        for ($i = 1; $i <= count($matrizCfinal); $i++) {
                            $varexpI = explode("|", $matrizIFinal[$i]);
                            $varexplD = explode("|", $matrizDfinal[$i]);
                            $varexplC = explode("|", $matrizCfinal[$i]);
                            $varexplPorc = explode("|", $matrizExpPorcentaje[$i]);
                            for ($j = 0; $j < count($varexpI); $j++) {
                                //var_dump($j);
                                if ($varexplD[$j] != "") {
                                    $sql = "CALL  MigracionCarguePresupuesto1 ('" . quitar_tildes($presupuestoNomb) . "','" . $nomArea . "','" . $varexplD[$j] . "','" . $matrizJbaremo[$i] . "','" . $matrizJbaremoitem[$i] . "','" . quitar_tildes($matriz[$i]) . "',1," . $varexpI[$j] . ",'" . $varexplPorc[$j] . "','" . trim(quitar_tildes($varexplC[$j])) . "');";
                                    var_dump($sql);
                                    $resultado = $obj_bd->EjecutaConsulta($sql);
                                    if ($resultado != "1") {
                                        var_dump("Error ejecutando :" . $sql . "- Error : " . $resultado);
                                    }
                                }
                            }
                        }
                    } else {
                        var_dump("Error ejecutando :" . $sql . "- Error : " . $resultado);
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