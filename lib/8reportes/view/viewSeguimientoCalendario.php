<?php
$id_presupuesto = filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING);
?>

<script src="../../../sources/jquery/jquery-2.1.4.js"></script>
<script src="../../../sources/css/bootstrap-3.3.5-dist/js/bootstrap.js"></script>

<link rel="stylesheet" href="../../../sources/css/bootstrap-3.3.5-dist/css/bootstrap.css">
<link href="../../../sources/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">


<script src="../../../sources/jquery/jquery/dist/jquery.min.js"></script> 
<script src="../../../sources/css/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../js/reportes.js"></script>  



<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">  
        <div id="contenido">

            <table class="table table-bordered table-striped" id="tb_seccion_productos" style="">
                <tr rowspan="2">
                    <td colspan="10"><center><h4>HISTORIAL SEGUIMIENTO</h4></center></td>                    
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>   
                <td colspan="3" align="center"> 
                    <table class="table table-bordered table-striped"  style="font-size:11px">
                        <thead>
                            <tr>
                                <th>No.</th>                                
                                <th>Fecha/Hora Inicio</th>
                                <th>Fecha/Hora Fin</th>
                                <th>Observaciones</th>                                                     
                                <th>Responsable</th>  
                            </tr>
                        </thead>
                        <tbody id="data_historico_seg">
                        </tbody>
                    </table>                    
                </td>

            </table>
        </div>

    </div>
</div>

<script>

    var jsonSeguiniento = VistaSeguimientoCalendario('<?php echo $id_presupuesto; ?>');
    
    if (jsonSeguiniento == 0) {
        
        var alertaVacio = '<div class="panel panel-info">' +
                '<div class="panel-heading">Histórico seguimiento.</div>' +
                '<div class="panel-body"><h5><center><strong>Señor usuarios, No hay histórico reportado para esta labor..</strong></center></h5></div>' +
                '</div>';
        $("#contenido").html(alertaVacio);
    } else {

        $.each(jsonSeguiniento.dataSeguimiento, function (key2, data) {
                    
                data_table = "<tr>" +
                        "<td>" + data.seguimiento_num + "</td>" +
                        "<td>" + data.seguimiento_fechaini + " "+ data.seguimiento_horaini+"</td>" +
                        "<td>" + data.seguimiento_fechafin + " "+ data.seguimiento_horafin+"</td>" +
                        "<td>" + data.seguimiento_obs + "</td>" +
                        "<td>" + data.responsable + "</td>" +
                        
                        "</tr>";
                $("#data_historico_seg").append(data_table);
            

        });

    }



</script>
