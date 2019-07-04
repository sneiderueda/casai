<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$presupuesto_id = htmlspecialchars(strip_tags(trim($_POST['prusupuesto_id'])));
$ot_id = $_POST['ot_id'];
?>

<script>
    var presupuesto_id =<?php echo $presupuesto_id; ?>;
    var ot_id =<?php echo $ot_id; ?>;

    var concat = "";
    ListArea('slAreaOT');
    cargar_normas(presupuesto_id);
    var jsondetalle = JsonDetalleActividad(presupuesto_id);
    $("#labor").html(jsondetalle.labor_id + ' - ' + jsondetalle.labor_descripcion);
    // console.log(ot_id);
    var DataPresupuesto = JsonPresupuesto(<?php echo $presupuesto_id; ?>,ot_id);
    ListUserArea('List_slIngOT', DataPresupuesto.area_id);
    ListUserArea('slIngOT', DataPresupuesto.area_id);

//    $("#slAreaOT").val(DataPresupuesto.area_id);
//    $("#slIngOT").val(DataPresupuesto.presupuesto_encargado);
    $("#slAreaOT").val("");
    $("#slIngOT").val("");

    $("#txtInicioOT").val(DataPresupuesto.presupuesto_fechaini);
    $("#txtFnicioOT").val(DataPresupuesto.presupuesto_fechafin);
    $("#txtHoraIni").val(DataPresupuesto.presupuesto_horaini);
    $("#txtHoraFin").val(DataPresupuesto.presupuesto_horafin);
    $("#txt_obs_programacion").val(DataPresupuesto.presupuesto_programacion_obs);
    $("#txt_vehiculo").val(DataPresupuesto.presupuesto_vehiculo);
    // $("#txt_ot").val(DataPresupuesto.ordentrabajo_id);
    $("#ot").append(DataPresupuesto.ordentrabajo_num + "/" +DataPresupuesto.interna_consecutivo);
    $("#txt_ot").val(ot_id);

    if (DataPresupuesto.presupuesto_fechaini == "0000-00-00") {
        $("#txtInicioOT").val("");
    }
    if (DataPresupuesto.presupuesto_fechafin == "0000-00-00") {
        $("#txtFnicioOT").val("");
    }

    /*Listar encargados*/
    var JsonEncargados = JsonEncargadosPresupuesto(<?php echo $presupuesto_id; ?>);
    if (JsonEncargados.registros == 0 || JsonEncargados.registros == "0") {
        $("#tableMoreEncargado").css("display", "none");
    } else {
        $("#tableMoreEncargado").removeAttr("style");

        $.each(JsonEncargados.encargados, function (key, data_encargado) {
            table_encargados = '<tr id="tr_encargado_asig' + data_encargado.perfilusuario_id + '">' +
                    '<td><button type="button" name="btn_eliminar_enc_' + data_encargado.perfilusuario_id +
                    '" id="btn_eliminar_enc_' + data_encargado.perfilusuario_id + '" class="btn btn-danger btn-xs" onclick="delMoreEncargado(' + data_encargado.perfilusuario_id + ');contadorFilasTablaGeneral(' + 
                    concat + 'encargadoAddTR' + concat + ',' + concat + 'txt_add_encargado' + concat + ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + data_encargado.usuario_apellidos + ' '+data_encargado.usuario_nombre +' '+data_encargado.perfil_nombre+
                    '<input type="hidden" name="idAddEncargadoPg[]" id="idAddEncargadoPg" value="' + data_encargado.perfilusuario_id + '">' +
                    '<input type="hidden" name="idAddEncargadoAreaPg[]" id="idAddEncargadoAreaPg" value="' + data_encargado.area_id + '">' +
                    '</td>' +
                    '<td>'+data_encargado.area_nombre+'</td>' +
                    '</tr>';

            $("#encargadoAddTR").append(table_encargados);
        });
    }

    /**/

    /*listado de tecnicos*/
    var JsonTecnicosProgramados = JsonTecnicosPresupuesto(<?php echo $presupuesto_id; ?>);

    if (JsonTecnicosProgramados.registros == 0 || JsonTecnicosProgramados.registros == "0") {
        $("#tableMoreIngeniero").css("display", "none");
    } else {
        $("#tableMoreIngeniero").removeAttr("style");

        $.each(JsonTecnicosProgramados.tecnicos, function (key, data_tecnico) {
            table_tecnicos = '<tr id="tr_ingeniero_asig' + data_tecnico.perfilusuario_id + '">' +
                    '<td><button type="button" name="btn_eliminar_ing_' + data_tecnico.perfilusuario_id + '" id="btn_eliminar_ing_' + data_tecnico.perfilusuario_id + '" class="btn btn-danger btn-xs" onclick="delMoreIngeniero(' + data_tecnico.perfilusuario_id + ');contadorFilasTablaGeneral(' + concat + 'ingenieroAddTR' + concat + ',' + concat + 'txt_add_ingeniero' + concat + ');"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>Eliminar</button></td>' +
                    '<td>' + data_tecnico.tecnico +
                    '<input type="hidden" name="idAddIngenieroPg[]" id="idAddIngenieroPg" value="' + data_tecnico.perfilusuario_id + '">' +
                    '</td>' +
                    '</tr>';

            $("#ingenieroAddTR").append(table_tecnicos);
        });
    }

    /**/



    $('#frm_DataProgramarOT').validate({
        rules: {
            //slAreaOT: {required: true},
            //slIngOT: {required: true},
            txtInicioOT: {required: true},
            txtFnicioOT: {required: true}

        },
        messages: {
        },
        debug: true,
        invalidHandler: function () {

            alert('Hay información en el formulario sin diligenciar por favor completarla');
            //$("#messageDataUser").html(htmlMessage);
            return false;
        },
        submitHandler: function (form) {
            /*Validar fechas ingresadas*/
            var fechaInicial = $("#txtInicioOT").val();
            var fechaFinal = $("#txtFnicioOT").val();

            /**/
            var datanuevafechaInicial = fechaInicial.split("-");
            var datanuevafechaFinal = fechaFinal.split("-");

            /*[0]=dia [1]=mes [2]=año*/
            var primera = Date.parse(datanuevafechaInicial[1] + "/" + datanuevafechaInicial[2] + "/" + datanuevafechaInicial[0]);
            var segunda = Date.parse(datanuevafechaFinal[1] + "/" + datanuevafechaFinal[2] + "/" + datanuevafechaFinal[0]);
            /*Validar fechas ingresadas*/
            /**/

            if (primera > segunda) {
                alert('Señor usuario por favor revise las fechas, la fecha final no puede ser menor a la inicial');
                return false;
            } else {
                SaveProgramaOT(<?php echo $presupuesto_id; ?>);
            }

        }
    });



</script>

<div class="container">
    <label>No. ot interna: </label>
    <label id="ot"></label>
    <input type="hidden" id="txt_ot">
    <div class="row">
        <div class="col-md-12 ">
            <div role="tabpanel" class="">
                <ul class="nav nav-tabs borde_inf" role="tablist" id="agregar_tab">
                    <li role="presentation" id="tab0" class="active"><a href="#seccion4" aria-controls="seccion4" data-toggle="tab" role="tab">Asignar Tareas</a></li>
                    <li role="presentation" id="tab1" class=""><a href="#seccion5" aria-controls="seccion5" data-toggle="tab" role="tab">Normatividad</a></li>
                    <li role="presentation" id="tab1" class=""><a href="#seccion6" aria-controls="seccion6" data-toggle="tab" role="tab">Vehiculo</a></li>
                </ul>
            </div>

            <div class="tab-content" id="tab-content">

                <div role="tabpanel" class="tab-pane active" id="seccion4">
                    </br>
                    <form id="frm_DataProgramarOT" class="form-horizontal">    
                        <fieldset>        
                            <div class="form-group">
                                <label for="" class="fondo letraN col-sm-3 control-label">Labor:</label>
                                <div class="col-sm-5" id="labor">                      
                                </div>
                            </div>

                            <!-- Area-->
                            <div class="form-group">
                                <label for="lb_area_ot" class="fondo letraN col-sm-3 control-label">Area:</label>
                                <div class="col-sm-5">                
                                    <select id="slAreaOT" name="slAreaOT" class="form-control" onchange="ListUserArea('slIngOT', this.value); ListUserArea('List_slIngOT', this.value);">
                                    </select>                
                                </div>
                            </div>

                            <!-- Encargado -->
                            <div class="form-group">
                                <label for="lb_ing_ot" class="fondo letraN col-sm-3 control-label">Jefe de Cuadrilla:</label>
                                <div class="col-sm-5">                
                                    <select id="slIngOT" name="slIngOT" class="form-control" style="width:400px">
                                    </select>      
                                    <input type="hidden" name="txt_add_encargado" id="txt_add_encargado" value="">
                                    <button type="button" name="btnAddEncargado" id="btnAddEncargado" class="btn btn-primary btn-xs" onclick="addEncargadoProgramacion();
                                            contadorFilasTablaGeneral('encargadoAddTR', 'txt_add_encargado');"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button>&nbsp;
                                    <button type="button" name="btnCancelEncargado" id="btnCancelEncargado" class="btn btn-success btn-xs" onclick="clearMoreEncargado();
                                            contadorFilasTablaGeneral('encargadoAddTR', 'txt_add_encargado');"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Limpiar</button>
                                    <div id="tableMoreEncargado" style="display: none;">
                                        <table class="table table-bordered table-hover" id="tb_encargados">
                                            <thead>
                                                <tr class="fondo letraN">
                                                    <th>Acción</th>
                                                    <th>Responsable</th>
                                                    <th>Area</th>
                                                </tr>
                                            </thead>
                                            <tbody id="encargadoAddTR">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Ingenieros a cargo -->
                            <div class="form-group">
                                <label for="lb_ingLs_ot" class="fondo letraN col-sm-3 control-label">Personal involucrado:</label>
                                <div class="col-sm-5">                
                                    <select id="List_slIngOT" name="List_slIngOT" class="form-control" style="width:400px">
                                    </select>    
                                    <input type="hidden" name="txt_add_ingeniero" id="txt_add_ingeniero" value="">
                                    <button type="button" name="btnAddTecnico" id="btnAddTecnico" class="btn btn-primary btn-xs" onclick="addIngenieroProgramacion();
                                            contadorFilasTablaGeneral('ingenieroAddTR', 'txt_add_ingeniero');"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button>&nbsp;
                                    <button type="button" name="btnCancelTecnico" id="btnCancelTecnico" class="btn btn-success btn-xs" onclick="clearMoreIngeniero();
                                            contadorFilasTablaGeneral('ingenieroAddTR', 'txt_add_ingeniero');"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Limpiar</button>
                                    <div id="tableMoreIngeniero" style="display: none;">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="fondo letraN">
                                                    <th>Acción</th>
                                                    <th>Ingeniero</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ingenieroAddTR">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="controlDataProfesional"></div>
                                </div>
                            </div>
                            
                            <!-- Observaciones de la programacion-->
                            <div class="form-group">
                                <label for="lb_labor" class="fondo letraN col-sm-3 control-label">Observaciones Coordinador:</label>
                                <div class="col-sm-5">  
                                    <textarea class="form-control data"  id="txt_obs_programacion" name="txt_obs_programacion"rows="5" cols="40" placeholder="" ></textarea>                
                                </div>
                            </div>

                            <!--Fecha inicio-->
                            <div class="form-group">
                                <label for="lb_inicio" class="fondo letraN col-sm-3 control-label">Inicio Ejecucion:</label>
                                <div class="col-sm-5 input-group date" id="InicioOT"  style="width:200px">                
                                    <input type='text' id="txtInicioOT" name="txtInicioOT" class="form-control data" readonly />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                                </div>
                            </div>

                            <!--Hora inicio-->
                            <div class="form-group">
                                <label for="lb_inicio_hora" class="col-sm-3 control-label">Hora Inicio Ejecucion:</label>      
                                <div id="datetimepicker3" class="col-sm-5 input-group date" style="width:200px">
                                    <input data-format="hh:mm:ss" type="text" name="txtHoraIni" id="txtHoraIni" readonly></input>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                    
                                </div>          
                            </div>

                            <!--Fecha fin-->
                            <div class="form-group">
                                <label for="lb_fin" class="fondo letraN col-sm-3 control-label">Fin Ejecucion:</label>
                                <div class="col-sm-5 input-group date" id="FinOT" style="width:200px">                
                                    <input type='text' id="txtFnicioOT" name="txtFnicioOT" class="form-control data" readonly />
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
                                </div>
                            </div>

                            <!--Hora Fin-->
                            <div class="form-group">
                                <label for="lb_inicio_hora" class=" col-sm-3 control-label">Hora Fin Ejecucion:</label>      
                                <div id="datetimepicker4" class="col-sm-5 input-group date" style="width:200px">
                                    <input data-format="hh:mm:ss" type="text" name="txtHoraFin" id="txtHoraFin" readonly></input>
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>                                    
                                </div>          
                            </div>

                            <!--Botones-->
                            <div class="form-group">
                                <div class="fondo">
                                    <div class="col-sm-5"></div>
                                        <button id="btoGuardar" name="btoGuardar" class=" btn btn-primary" type="submit" >Guardar</button>                                
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>

                <div role="tabpanel" class="tab-pane" id="seccion5">
                    <!-- Normas -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">      
                            <div id="normatividad"></div>      
                        </div>
                    </div>
                </div>
            
                <div role="tabpanel" class="tab-pane" id="seccion6">
                    <!-- Vehiculo -->
                    <div class="form-group">
                        <label for="lb_vehiculo" class="fondo letraN col-sm-3 control-label">Vehiculo:</label>
                        <div class="col-sm-5">                
                            <input type="text" class="form-control data" id="txt_vehiculo" name="txt_vehiculo" placeholder="Si aplica">                
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('#InicioOT').datetimepicker({
            //  viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017'

        });
        $('#FinOT').datetimepicker({
            // viewMode: 'years',
            format: 'YYYY-MM-DD',
            minDate: '01-01-2017'
        });

        $('#datetimepicker3').datetimepicker({
            pickDate: false
        });
        $('#datetimepicker4').datetimepicker({
            pickDate: false
        });
    });
</script>
