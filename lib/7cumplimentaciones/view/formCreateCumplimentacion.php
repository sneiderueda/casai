<script type="text/javascript">
    $(function () {
        $('#txtDateApertura').datetimepicker({
            language: 'es',
            minDate: new Date(),
            useCurrent: false,
            dateFormat: 'dd-mm-yy',
            format: 'YYYY-MM-DD HH:mm:ss',
            minDate: '01-01-2016'
            // minDate: getFormattedDate(new Date())
        });
        $('#txtDateInicio').datetimepicker({
            language: 'es',
             minDate: new Date(),
            useCurrent: false,
            dateFormat: 'dd-mm-yy',
            format: 'YYYY-MM-DD HH:mm:ss',
            minDate: '01-01-2016'
            // minDate: getFormattedDate(new Date())
        });
        $('#txtDateCierre').datetimepicker({
            language: 'es',
            minDate: new Date(),
            useCurrent: false,
            dateFormat: 'dd-mm-yy',
            format: 'YYYY-MM-DD HH:mm:ss',
            minDate: '01-01-2016'
            // minDate: getFormattedDate(new Date())
        });
        $('#PresCierre').datetimepicker({
            language: 'es',
            minDate: new Date(),
            useCurrent: false,
            dateFormat: 'dd-mm-yy',
            format: 'YYYY-MM-DD HH:mm:ss',
            minDate: '01-01-2016'
            // minDate: getFormattedDate(new Date())
        });
        $('#txtDateFinal').datetimepicker({
            language: 'es',
            minDate: new Date(),
            useCurrent: false,
            dateFormat: 'dd-mm-yy',
            format: 'YYYY-MM-DD HH:mm:ss',
            minDate: '01-01-2016'
            // minDate: getFormattedDate(new Date())
        });

    });
    function getFormattedDate(date) {
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear().toString().slice(2);
        return day + '-' + month + '-' + year;
    }


    $(document).ready(function () {

        ListSubestacion('slSubestacion');
        ListGestor('slGestor');
        ListTipDescargo('sltipoDescargo');


        $('#frm_CreateCumplimentacion').validate({

            rules: {
                txtDescargo: {required: true},
                sltipoDescargo: {required: true},
                slSubestacion: {required: true},
                txt_add_ingeniero: {required: true},
                txtDateInicio: {required: true},
                txtDateFinal: {required: true},
                slc_jornada: {required: true},
                slGestor: {required: true}
            },
            messages: {
                txtDescargo: {required: 'Ingrese el número de descargo.'},
                sltipoDescargo: {required: 'Seleccione el tipo de descargo.'},
                slSubestacion: {required: 'Seleccione una subestación.'},
                txt_add_ingeniero: {required: 'Ingrese los ingenieros encargados a esta subestación.'},
                txtDateInicio: {required: 'Ingrese la fecha de inicio de CODENSA.'},
                txtDateFinal: {required: 'Ingrese la fecha de fin de CODENSA.'},
                slc_jornada: {required: 'Seleccione la jornada.'},
                slGestor: {required: 'Seleccione el gestor.'}

            },
            debug: true,
            invalidHandler: function () {
                alert('Hay información en el formulario sin diligenciar por favor completarla');
            },
            submitHandler: function (form) {
                saveCumplimentacion();

            }
        });
    });
</script>

<br>
<br>
<br>
<br>

<fieldset class="letraBl">
<legend class="titulo">Datos Cumplimentacion</legend>

<form class="form-horizontal" name="frm_CreateCumplimentacion" id="frm_CreateCumplimentacion" method="POST" enctype='multipart/form-data'>


    <table class="table table-bordered table-hover">
        <tr>
            <td><b>Numero Descargo:</b></td>
            <td>
                <input type="text" class="form-control data" id="txtDescargo" name="txtDescargo" placeholder="Numero Descargo" required="true" onkeypress="return numeros(event)" >                
            </td>
        </tr>

        <tr>
            <td><b>Tipo Descargo:</b></td>
            <td>
                <select id="sltipoDescargo" name="sltipoDescargo" class="form-control data" required="true" 
                        onchange="AddTypeDescargo(this.value);">
                </select>
            </td>
        </tr>

        <tr>
            <td><b>Subestacion:</b></td>
            <td>
                <select id="slSubestacion" name="slSubestacion" class="form-control"  required="true" onchange="AddSubestacion(this.value);"  >
                </select> 
            </td>
        </tr>

        <tr>
            <td><b>Ingenieros:</b></td>
            <td>
                <select name="slc_usr_ingenieros" id="slc_usr_ingenieros" class="form-control" >
                    <option value="">-Seleccione-</option>
                </select><br> 
                <input type="hidden" name="txt_add_ingeniero" id="txt_add_ingeniero" value="">
                <button type="button" name="btnAddTecnico" id="btnAddTecnico" class="btn btn-default btn-xs" onclick="addMoreIngeniero('messageProgramVisit');
                        contadorFilasTablaGeneral('ingenieroAddTR', 'txt_add_ingeniero');"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Adicionar</button>&nbsp;
                <button type="button" name="btnCancelTecnico" id="btnCancelTecnico" class="btn btn-default btn-xs" onclick="clearMoreIngeniero();
                        contadorFilasTablaGeneral('ingenieroAddTR', 'txt_add_ingeniero');"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Limpiar</button>
                <div id="tableMoreIngeniero" style="display: none;">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Acción</th>
                                <th>Ingeniero</th>
                            </tr>
                        </thead>
                        <tbody id="ingenieroAddTR">
                        </tbody>
                    </table>
                </div>
                <div id="controlDataProfesional"></div>
            </td>
        </tr>

        <tr>
            <td><b>Fecha Codensa</b></td>
            <td>
                <b>Inicio :</b>&nbsp;
                <div class='input-group date' id='DateInicio'>
                    <input type='text' id="txtDateInicio" name="txtDateInicio" class="form-control" readonly onblur="getJornada()"  />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>     
                </div>
                <b>Fin :</b>&nbsp;
                <div class='input-group date' id='PresFinal'>
                    <input type='text' id="txtDateFinal" name="txtDateFinal" class="form-control" readonly onblur="getJornada()" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span> 
                </div>

                <b>Jornada :</b>&nbsp;

                <select class="form-control" id="slc_jornada" name="slc_jornada" >
                    <option value="">-Seleccione-</option>                        
                    <option value="1">DIURNO</option>
                    <option value="2">NOCTURNO</option>
                </select>  

            </td>
        </tr>

        <tr>
            <td><b>Gestor:</b></td>
            <td>
                <select id="slGestor" name="slGestor" class="form-control data" required="true">
                </select>
            </td>
        </tr>
    </table>

    <legend class="titulo">Datos Apertura y Cierre</legend>

    <table class="table table-bordered table-hover">
        <tr>
            <td><b>Datos de Apertura</b></td>
            <td>
                <b>Operador :</b>&nbsp;

                <input type="text" class="form-control data" id="txt_apertura_ope" name="txt_apertura_ope" placeholder="Nombre del operador de apertura">  

                <b>Inicio :</b>&nbsp;
                <div class='input-group date' id='PresApertura'>
                    <input type='text' id="txtDateApertura" name="txtDateApertura" class="form-control" readonly />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>     
                </div>

            </td>
        </tr>

        <tr>
            <td><b>Datos de Cierre</b></td>
            <td>
                <b>Operador :</b>&nbsp;

                <input type="text" class="form-control data" id="txt_cierre_ope" name="txt_cierre_ope" placeholder="Nombre del operador de cierre">                      

                <b>Fin :</b>&nbsp;
                <div class='input-group date' id='PresCierre'>
                    <input type='text' id="txtDateCierre" name="txtDateCierre" class="form-control" readonly />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>  
                </div>
            </td>
        </tr>

        <tr>
            <td><b>Observaciones</b></td>
            <td>
                <textarea name="txt_obs" id="txt_obs" class="form-control" rows="3"></textarea>
            </td>
        </tr>

        <tr>
            <td><b>Soporte Descargo</b></td>
            <td id="up_doc_soporte">
                <input type="file"  name="docSoporteCumplimentacion" id="docSoporteCumplimentacion">
            </td>
        </tr>

        <tr>
            <td colspan="2">
        <center>
            <button type="submit" class="btn btn-primary" name="btnGuardarVisita" id="btnGuardarVisita">Guardar</button>
            <label id="btnCancelarProgVisita"></label>
            <div id="dialog_arch" style="display: none;"></div>
            <div id="ModificarDocActVis"></div>
        </center>                        
        </td>
        </tr>

    </table>
    <div id="md_sub"></div>
</form>


<div id="div_subestacion"></div>
</fieldset>