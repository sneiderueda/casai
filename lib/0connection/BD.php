<?php

/* PHP 7.++
 * Description of BD
 * parametros : recibe un string con una consulta de sql de tipo : INSERT,SELECT,DELETE,UPDATE
 * accion : ejecuta la consulta y retorna FALSE si la consulta fallo  o un resul de tipo MYSQL O ORACLE si la consulta fue exitosa
 * @author jennifer.cabiativa
 */

include_once ("connection.php");

class BD {

    var $conexion;

    public function MySQL() {

        $server = DNS;
        $usuario = USUARIO;
        $pass = PASSWORD;
        $BD = BD;

        $conexion = mysqli_connect($server, $usuario, $pass, $BD);

        //Comprobamos si la conexión ha tenido exito
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        mysqli_select_db($conexion, BD);

        //devolvemos el objeto de conexión para usarlo en las consultas  
        return $conexion;
    }

    public function EjecutaConsulta($sql) {

        /* Parte de oracle */

        if (MOTOR == 'ORACLE') {
            $resul = oci_parse(conexion, $sql);
            $re = oci_execute($resul);

            if ($re) {
                return $resul;
            } else {
                $error = oci_error($resul);
                return $error['sqltext'];
            }


            /* Parte de mysql */
        } else if (MOTOR == 'MYSQL') {

            $conexion = $this->MySQL();
            $resul = mysqli_query($conexion, $sql);

            if ($resul) {
                return $resul;
            } else {
                return "error->" . mysqli_error($conexion);
            }
        }
    }

    /*
     * parametros :
     *  $campo_id = el campo referente al id de la tabla.
     *  $tabla = la tabla a la que se le quiere tomar su ultimo id.
     * accion : esta funcion retorna el ultimo id de una tabla.
     */

    public function IdUltimoRegistro($campo_identificacion, $tabla) {

        /* Parte de oracle */

        if (MOTOR == 'ORACLE') {
            $resul = oci_parse(conexion, "SELECT MAX($campo_identificacion)AS MAXIMO FROM $tabla");
            oci_execute($resul);

            if ($resul) {
                $arreglo = oci_fetch_array($resul);
                return $arreglo['MAXIMO'];
            } else {
                return "error->" . oci_error();
            }

            /* Parte de mysql */
        } else if (MOTOR == 'MYSQL') {

            $conexion = $this->MySQL();
            $resul = mysqli_query($conexion, "SELECT MAX($campo_identificacion)AS MAXIMO FROM $tabla");

            if ($resul) {

                $arreglo = mysqli_fetch_array($resul);
                return $arreglo['MAXIMO'];
            } else {
                return "error->" . mysqli_error($conexion);
            }
        }
    }

    /*
     * parametros :
     *  $resul = es un resul de tipo MYSQL retornato por la funcion EjecutaConsulta() .
     * accion : esta funcion recibe un result y retorna un arreglo de cada row de la consulta.
     * ejemplo : esta funcion se debe usar dentro de un while de la siguiente forma :
     *
     *      while ($row = $ob_bd->FuncionFetch($this->resultado)) {}
     */

    public function FuncionFetch($resul) {

        /* Parte de oracle */

        if (MOTOR == 'ORACLE') {
            return array_change_key_case(oci_fetch_array($resul), CASE_LOWER);
            /* Parte de mysql */
        } else if (MOTOR == 'MYSQL') {
            return @array_change_key_case(mysqli_fetch_array($resul), CASE_LOWER);
        }
    }

    /*
     * parametros :
     *  $stat = es un string el cual hace referencia a una consulta SQL .
     * accion : Segun la consulta ingresada retorna la cantidad de filas de esa consulta.
     */

    public function Filas($stat) {
        if (MOTOR == 'ORACLE') {
            $sql_rows = "SELECT COUNT(*) AS NUMBER_ROWS FROM (" . $stat . ")";
            $res = $this->EjecutaConsulta($sql_rows);
            $arreglo = oci_fetch_array($res);
            return $arreglo['NUMBER_ROWS'];
            /* Parte de mysql */
        } else if (MOTOR == 'MYSQL') {
            $conexion = $this->MySQL();
            $res = mysqli_query($conexion, $stat);
            return mysqli_num_rows($res);
        }
    }

    function obtenerFechaEnLetra($fecha) {
         $dia = $this->conocerDiaSemanaFecha($fecha);
        $num = date("j", strtotime($fecha));
        $anno = date("Y", strtotime($fecha));
        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];
        return $dia . ',' . $num . ',' . $mes . ',' . $anno;
    }

    function conocerDiaSemanaFecha($fecha) {
        $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $dia = $dias[date('w', strtotime($fecha))];
        return $dia;
    }

}
