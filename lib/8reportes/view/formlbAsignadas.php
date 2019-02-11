<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table"></i> Filtros de Reporte
                </div>
                <!-- /.panel-heading -->

                <div class="panel-body" style="margin: 10px 4px 4px 4px;"> 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <b>Contrato : </b>
                                    <select style="width: 50%" id="slc_contrato" onchange="graficaLaboresTerminadas(this.value,$('#anio').val()); ValorFacturaLabores(this.value,$('#anio').val());td_resumenAsignadasLb(this.value,$('#anio').val());">
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    <b>Dinero recaudado año : </b>
                                    <select id="anio" onchange="graficaLaboresTerminadas($('#slc_contrato').val(),this.value);ValorFacturaLabores($('#slc_contrato').val(),this.value);td_resumenAsignadasLb($('#slc_contrato').val(),this.value);">
                                        <option>TODO</option>
                                        <option>2017</option>
                                        <option selected="true">2018</option>
                                        <option>2019</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table"></i> Resumen Labores por Area Finalizadas
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="gr_labores">
                        <?php
                        include 'grLaboresTerminadas.php';
                        ?>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table"></i> Resumen Labores Asignadas
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="tb_resumen"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <!-- /.row -->
    <div class="row">

        <!-- /.col-lg-8 -->
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-table"></i> Detalle de Labores
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="td_detalle"></div>
                </div>
                <!-- /.panel-body -->
            </div>
        </div>

        <!-- /.col-lg-6 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-calendar"></i> Periodo de Ejecucion
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="calendario">
                        <?php include ('./Lbcalendario.php'); ?>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>


        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

<script>
    var slc_contrato=$("#slc_contrato").val();
    var year=$("#anio").val();
    
    ListContratClien('slc_contrato');
    td_resumenAsignadasLb(slc_contrato, year);

</script>