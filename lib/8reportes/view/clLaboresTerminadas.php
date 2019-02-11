
<?php
$hoy = date("Y-m-d");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />

<!--        <script src='components/fullcalendar/fullcalendar-3.9.0/fullcalendar.js'></script>-->

        <link href='sources/css/fullcalendar.min.css' rel='stylesheet' />
        <link href='sources/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
        <script src='sources/jquery/moment.min.js'></script>
        <script src='sources/jquery/fullcalendar.min.js'></script>
        <script src='sources/jquery/locale-all.js'></script>

        <script>

            $(document).ready(function () {
                CalendarioLaboresRealizadas('<?php echo $hoy; ?>');

            });

        </script>
        <style>

            body {
                margin: 40px 10px;
                padding: 0;
                font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                font-size: 14px;
            }

            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }

        </style>
    </head>
    <body>

        <div id='calendar'></div>

    </body>
</html>
