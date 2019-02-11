<?php
$opc = $_POST['data'];

if ($opc == "") {
    $opc = 0;
} 

?>

<link rel="stylesheet" href="sources/css/calendar.css">
<link href="sources/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript" src="sources/jquery/es-ES.js" ></script>
<script src="sources/jquery/moment.js" type="text/javascript"></script>
<script src="sources/jquery/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel="stylesheet" href="sources/css/bootstrap-datetimepicker.min.css" />
<script src="sources/jquery/bootstrap-datetimepicker.es.js" type="text/javascript"></script>
<script src="sources/jquery/underscore-min.js" type="text/javascript"></script>
<script src="js/calendar.js" type="text/javascript"></script>
<script src='sources/jquery/calendar.js'></script>

<meta charset="utf-8">
<div class="container">  
    <input type="hidden" class="form-control data" id="txt_idPresupuesto" name="txt_idPresupuesto" value="<?php echo $presupuesto_id; ?>" >                
    <div class="row">
        <div class="page-header"><h2></h2></div>
        <div class="pull-left form-inline"><br>
            <div class="btn-group">
                <button class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
                <button class="btn" data-calendar-nav="today">Hoy</button>
                <button class="btn btn-primary" data-calendar-nav="next">Siguiente >></button>
            </div>
            <div class="btn-group">
                <button class="btn btn-warning" data-calendar-view="year">Año</button>
                <button class="btn btn-warning active" data-calendar-view="month">Mes</button>
                <button class="btn btn-warning" data-calendar-view="week">Semana</button>
                <button class="btn btn-warning" data-calendar-view="day">Dia</button>
            </div>

        </div>
    </div>
    <hr>
    <div class="row">
        <div id="calendar" style="background: white;"></div>
        <br><br>
    </div>
    <!--ventana modal para el calendario-->
    <div class="modal fade" id="events-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body" style="height: 600px;">
                    <p>One fine body&hellip;</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript">
//    $(document).ready(function () {
//        listViewCalendarDiary('listCalendario');
//    });
    var jsonSeguimientocalendario = seguimientoCalendario();
    (function ($) {
        var date = new Date();
        var yyyy = date.getFullYear().toString();
        var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
        var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();


        var options = {
            modal: '#events-modal',
            modal_type: 'iframe',
            events_source: 'lib/8reportes/modelo/MD_calendarioLb.php?opc=<?php echo $opc; ?>',
            // events_source: jsonSeguimientocalendario,
            view: 'month',
            day: yyyy + "-" + mm + "-" + dd,
            language: 'es-ES',
            tmpl_path: 'lib/8reportes/view/tmpls/',
            tmpl_cache: false,
            time_start: '06:00',
            time_end: '22:00',
            time_split: '30',
            width: '100%',
            onAfterEventsLoad: function (events)
            {

                if (!events)
                {
                    return;
                }
                var list = $('#eventlist');
                list.html('');

                $.each(events, function (key, val)
                {
                    $(document.createElement('li'))
                            .html('<a href="' + val.url + '">' + val.title + '</a>')
                            .appendTo(list);
                });
            },
            onAfterViewLoad: function (view)
            {
                $('.page-header h2').text(this.getTitle());
                $('.btn-group button').removeClass('active');
                $('button[data-calendar-view="' + view + '"]').addClass('active');
            },
            classes: {
                months: {
                    general: 'label'
                }
            }
        };

//.html('<a href="' + val.id_solicitud_programacion + '">' + val.id_solicitud_programacion + '</a>')

        var calendar = $('#calendar').calendar(options);

        $('.btn-group button[data-calendar-nav]').each(function ()
        {
            var $this = $(this);
            $this.click(function ()
            {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function ()
        {
            var $this = $(this);
            $this.click(function ()
            {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function ()
        {
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });
    }(jQuery));
</script>