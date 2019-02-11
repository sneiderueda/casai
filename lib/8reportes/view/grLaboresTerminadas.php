

<!doctype html>
<html>

    <head>
        <title>Line Chart</title>

        <script src='components/Chart/src/charts/Chart.bundle.js'></script>
        <script src='components/Chart/utils.js'></script>
        <style>
            canvas{
                -moz-user-select: none;
                -webkit-user-select: none;
                -ms-user-select: none;
            }
        </style>
    </head>

    <body>

        <div class="panel-body" style="margin: 10px 4px 4px 4px;"> 
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <canvas id="canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xs-4 col-sm-4 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">

                            <table class="table table-bordered table-striped" id="tb_seccion_productos" style="">
                                <tr rowspan="2">
                                    <td colspan="10"><center><h4>Valor en pesos por Area</h4></center></td>                    
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>   
                                <td colspan="3" align="center"> 
                                    <table class="table table-bordered table-striped"  style="font-size:11px">
                                        <thead>
                                            <tr>
                                                <th>Area</th>                                
                                                <th>Total ($)</th>                                                      
                                            </tr>
                                        </thead>
                                        <tbody id="data_valor">
                                        </tbody>
                                    </table>                    
                                </td>

                            </table>


                        </div>
                    </div>
                    <center><p class="announcement-heading"><h3><span class="label label-success" id="total_labores"></span></h3></p></center>
<!--                    <p class="announcement-text" id="total_labores"></p>-->
                </div>

            </div>
            <div class="col-xs-2 col-sm-2 col-md-2"></div>
        </div> 



        <br>
        <br>
        <!--        <button id="randomizeData">Randomize Data</button>
                <button id="addDataset">Add Dataset</button>
                <button id="removeDataset">Remove Dataset</button>
                <button id="addData">Add Data</button>
                <button id="removeData">Remove Data</button>-->
        <script>
            var year = $("#anio").val();
            graficaLaboresTerminadas('', year);
            ValorFacturaLabores('', year);
//            var jsonValor = ValorFacturaLabores('',year);
//            var area = "";
//            console.log(jsonValor);
//            if (jsonValor == 0) {
//
//                var alertaVacio = '<div class="panel panel-info">' +
//                        '<div class="panel-heading">No hay datos.</div>' +
//                        '<div class="panel-body"><h5><center><strong>Señor usuarios, No hay dinero de las labores finalizadas.</strong></center></h5></div>' +
//                        '</div>';
//                $("#tb_valor").html(alertaVacio);
//            } else {
//
//                $.each(jsonValor.dataValorlabores, function (key2, data) {
//
//
//                    data_table = "<tr>" +
//                            "<td>" + data.area_nombre + "</td>" +
//                            "<td>" + data.factura + "</td>" +
//                            "</tr>";
//                    $("#data_valor").append(data_table);
//
//
//                });
//
//                $("#total_labores").html("Total dinero $" + jsonValor.valor_total);
//            }
        </script>
    </body>

</html>