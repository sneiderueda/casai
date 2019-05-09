<?php
/*
  Autor:jennifer.cabiativa@gmail.com
 */


  $detallepresupuesto_id = htmlspecialchars(strip_tags(trim($_POST['data'])));

  ?>

  <!DOCTYPE html>

  <html lang="en">

  <form id="frm_DetalleOt" class="form-horizontal">    
    <input type="hidden" class="form-control" id="detallepresupuesto_id" name="detallepresupuesto_id">                                    

        <!--actividades Agregadas-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">      
                <div id="ActividadesPresupuestoAsignadasOT"></div>
            </div>
        </div>


    <fieldset style="color:black;">

        <legend class="titulo">Datos Presupuesto</legend>            

        <!-- Presupuesto-->
        <div class="form-group">
            <label for="lb_nombre" class="col-sm-3 control-label">Nombre:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control" id="txt_Otpresupuesto" name="txt_Otpresupuesto" disabled="disabled">
            </div>
        </div>

        <!-- Cliente-->
        <div class="form-group">
            <label for="lb_cliente" class="col-sm-3 control-label">Cliente:</label>
            <div class="col-sm-5">                
                <select id="slCliente_OT" name="slCliente_OT" class="form-control" disabled="disabled">
                </select>
            </div>
        </div>

        <!-- Subestacion-->
        <div class="form-group">
            <label for="lb_sub" class="col-sm-3 control-label">Subestacion:</label>
            <div class="col-sm-5">                
                <select id="slSubestacionOT" name="slSubestacionOT" class="form-control"  disabled="disabled">
                </select>                
            </div>
        </div>
        <br>


        <legend class="titulo">Orden de Trabajo</legend>            
        <!--NUMERO OT-->
        <div class="form-group">
            <label for="lb_numero" class="col-sm-3 control-label">No. Orden:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control date" id="txt_num_orden" name="txt_num_orden" placeholder="Numero de la Orden" required="true" onblur="aMayusculas(this.value, this.id);" disabled="disabled">
            </div>
        </div>

        <!--ORDEN GOM-->
        <div class="form-group">
            <label for="lb_numero" class="col-sm-3 control-label">Orden GOM:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control date" id="txt_orden_gom" name="txt_orden_gom" placeholder="Orden GOM" onblur="aMayusculas(this.value, this.id);" disabled="disabled">
            </div>
        </div>


        <!--CONTRATISTA-->
        <div class="form-group">
            <label for="lb_contratista" class="col-sm-3 control-label">Contratista:</label>
            <div class="col-sm-5">                
                <input type="text" class="form-control date" id="txt_contratista" name="txt_contratista" placeholder="Nombre del Contratista" required="true" value="AC ENERGY" onblur="aMayusculas(this.value, this.id);" disabled="disabled">
            </div>
        </div>


        <!--DETALLE-->
        <div class="form-group">
            <label for="lb_detalle" class="col-sm-3 control-label">Nombre del proyecto:</label>
            <div class="col-sm-5">  
                <textarea class="form-control date"  id="txt_detalle" name="txt_detalle"rows="5" cols="40" required="true" placeholder="Detalle de la Orden de Trabajo" disabled="disabled" ></textarea>
            </div>
        </div>

        <!--DETALLE-->
        <div class="form-group">
            <label for="lb_detalle" class="col-sm-3 control-label">Orden Presupuestal:</label>
            <div class="col-sm-5">  
                <input type="text" class="form-control date" id="txt_orden_presupuestal" name="txt_orden_presupuestal" placeholder="Orden Presupuestal" onblur="aMayusculas(this.value, this.id);" style="width:300px" disabled="disabled">
            </div>
        </div>

        <!--PEP-->
        <div class="form-group">
            <label for="lb_pep" class="col-sm-3 control-label">PEP:</label>
            <div class="col-sm-5">  
                <input type="text" class="form-control date" id="txt_pep" name="txt_pep" placeholder="PEP" onblur="aMayusculas(this.value, this.id);" style="width:300px" disabled="disabled">
            </div>
        </div>

        <!--Fecha Emision-->
        <div class="form-group">
            <label for="lb_emision" class="col-sm-3 control-label">Fecha Emision:</label>
            <div class="col-sm-5 input-group date" id='FechaEmision' style="width:200px" >                
                <input type='date' id="txtFechaEmision" name="txtFechaEmision"  required="true" class="form-control date"  disabled="disabled"/>
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>                    
            </div>
        </div>

        <!--Fecha Inicio -->
        <div class="form-group">
            <label for="lb_ini" class="col-sm-3 control-label">Fecha Inicio:</label>
            <div class="col-sm-5 input-group date" id='FechaInicio'  style="width:200px" >                
                <input type="date" id="txtPresInicioOT" name="txtPresInicioOT"  required="true" class="form-control date" disabled="disabled"/>
                <span class="input-group-addon" ><span class="glyphicon glyphicon-calendar" ></span></span>                    
            </div>
        </div>


        <!--tabla de la busqueda-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">      
                <div id="ActividadesPresupuestoOT"></div>      
            </div>
        </div>

        <!--actividades Agregadas-->
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">      
                <div id="ActividadesPresupuestoAsignadasOT"></div>
            </div>
        </div>

    </fieldset>

</form>
<div id="NoFacturar"></div>
</html>
<script type="text/javascript">
    var detallepresupuesto_id = '<?php echo $detallepresupuesto_id; ?>';
    ListContratClien('slCliente_OT');
    ListSubestacion('slSubestacionOT');

    if (detallepresupuesto_id != 0) {
        ListActividadesAfacturar('<?php echo $detallepresupuesto_id; ?>');
        JsonDetallePresupuesto('<?php echo $detallepresupuesto_id; ?>', '1');
        JsonDetalleOT('<?php echo $detallepresupuesto_id; ?>');
        CalValorPorcPresupuestoSub();
    }


</script>