<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


$cumplimentacion_id = htmlspecialchars(strip_tags(trim($_POST['data'])));
?>



<script type="text/javascript">
   $(function () {
     $('#txtDateApertura').datetimepicker({
   // dateFormat: 'dd-mm-yy',
   format:'YYYY-MM-DD HH:mm:ss',
    minDate: getFormattedDate(new Date())
});
     $('#txtDateCierre').datetimepicker({
   // dateFormat: 'dd-mm-yy',
   format:'YYYY-MM-DD HH:mm:ss',
    minDate: getFormattedDate(new Date())
});
     $('#txtDateInicio').datetimepicker({
   // dateFormat: 'dd-mm-yy',
   format:'YYYY-MM-DD HH:mm:ss',
    minDate: getFormattedDate(new Date())
});
     $('#txtDateFinal').datetimepicker({
   // dateFormat: 'dd-mm-yy',
   format:'YYYY-MM-DD HH:mm:ss',
    minDate: getFormattedDate(new Date())
});

 });
   function getFormattedDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear().toString().slice(2);
    return day + '-' + month + '-' + year;
  }
   ListSubestacion('slSubestacion');
   ListGestor('slGestor');
   ListTipDescargo('sltipoDescargo');

   var cumplimentacion_id = '<?php echo $cumplimentacion_id ?>';
   if (cumplimentacion_id != 0) {
            JsonDetalleCumplimentacion('<?php echo $cumplimentacion_id ?>');
    }
    
</script>
</br>
</br>
</br>
<form id="frm_CreateCumplimentacion" class="form-horizontal">                   
    <fieldset>
        <legend>Datos Cumplimentacion</legend>

        <!-- Cliente-->
        <div class="form-group">
            <label for="lb_DateApertura" class="col-sm-3 control-label">Fecha Apertura:</label>
            <div class="col-sm-5 input-group date" id='PresInicio' style="width:200px" >                
                <input type='text' id="txtDateApertura" name="txtDateApertura" class="form-control" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>

        <div class="form-group">
            <label for="lb_datecierre" class="col-sm-3 control-label">Fecha Cierre:</label>
            <div class="col-sm-5 input-group date" id='PresInicio' style="width:200px" >                
                <input type='text' id="txtDateCierre" name="txtDateCierre" class="form-control" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>
        <!--  Descargo-->
        <div class="form-group">
            <label for="lb_descargo" class="col-sm-3 control-label">Descargo:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txtDescargo" name="txtDescargo" placeholder="Descripcion descargo" required="true" >                
            </div>
        </div>
        <!-- Tipo de descargo-->
        <div class="form-group">
            <label for="lb_tipoDescargo" class="col-sm-3 control-label">Tipo Descargo:</label>
            <div class="col-sm-5">                
                <select id="sltipoDescargo" name="sltipoDescargo" class="form-control data" required="true"
                onchange="AddTypeDescargo(this.value);">
                </select>
            </div>
        </div>
         <!-- Subestacion-->
     <div class="form-group">
                <label for="lb_sub" class="col-sm-3 control-label">Subestacion:</label>
                <div class="col-sm-5">                
                    <select id="slSubestacion" name="slSubestacion" class="form-control"  required="true" onchange="AddSubestacion(this.value);">
                    </select>                
                </div>
         </div>
        <div class="form-group">
            <label for="lb_inicio" class="col-sm-3 control-label">Fecha Inicio Codensa:</label>
            <div class="col-sm-5 input-group date" id='PresInicio' style="width:200px" >                
                <input type='text' id="txtDateInicio" name="txtDateInicio" class="form-control" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>

        <div class="form-group">
            <label for="lb_final" class="col-sm-3 control-label">Fecha Final Codensa:</label>
            <div class="col-sm-5 input-group date" id='PresFinal' style="width:200px" >                
                <input type='text' id="txtDateFinal" name="txtDateFinal" class="form-control" readonly />
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>

        <div class="form-group">
            <label for="lb_Jornada" class="col-sm-3 control-label">Jornada:</label>
            <div class="col-sm-5">  
                <select class="form-control" id="slc_jornada" name="slc_jornada" >
                    <option value="">-Seleccione-</option>                        
                    <option value="1">DIURNO</option>
                    <option value="2">NOCTURNO</option>
                </select>                
            </div>
        </div>

        <div class="form-group">
            <label for="lb_gestor" class="col-sm-3 control-label">Gestor:</label>
            <div class="col-sm-5">                
                <select id="slGestor" name="slGestor" class="form-control data" required="true">
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="lb_labor" class="col-sm-3 control-label">Observaciones:</label>
            <div class="col-sm-5">  
                <textarea class="form-control data"  id="txt_observaciones" name="txt_labor"rows="5" cols="40" placeholder="Descripcion de la Labor" ></textarea>
                <!--                <input type="text" class="form-control data" id="txt_labor" name="txt_labor" placeholder="Descripcion de la Labor" >                -->
            </div>
        </div>
        <div class="form-group">
            <label for="lb_apertura" class="col-sm-3 control-label">Operador de apertura:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_apertura" name="txt_apertura" placeholder="Unidad de Medida">                
            </div>
        </div>
        <div class="form-group">
            <label for="lb_cierre" class="col-sm-3 control-label">Operario de cierre:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_cierre" name="txt_cierre" placeholder="Costo Unidad de Servicio" required="true" >                
            </div>
        </div>
        <div class="form-group">
            <label for="lb_ingenieros" class="col-sm-3 control-label">Ingenieros</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control data" id="txt_ingenieros" name="txt_ingenieros" placeholder="Costo Total de Actividades" required="true" >                
            </div>
        </div>

        <input type="hidden" name="txt_cumplimentacion_id" id="txt_cumplimentacion_id" value="<?php echo $cumplimentacion_id ?>">
        <div class="form-group" id="btn_saveActBaremo">
            <div class="col-sm-offset-4 col-sm-4">
                <button type="button" name="btnAddAcDescargo" id="btnAddAcDescargo" class="btn btn-default" onclick="editCumplimentacion();"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>Guardar</button>
            </div>
        </div>
    </div>
</fieldset>
<div id="md_sub"></div>
</form>
