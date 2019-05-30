<?php
include_once 'Components.php';
$components = new Components();
if ($components->sendRsForMail(null, array('nicolas.velasquez@ica.gov.co','nvelasquez72@gmail.com'),null,'Notificación', '<table border="1"><tr><td>Hola ñiño</td></tr><tr><td>Hola ñeñe </td></tr><tr><td>Hola ñiñi</td></tr><tr><td>Hola ñoño</td></tr><tr><td>Hola ñuñu</td></tr><tr><td>Hola áéíóú</td></tr></table>')) {
    echo 'Todo ok';
} else {
    $msg = 'Exisito algun error al enviar la notificacion a el administrador' . PHP_EOL . 'sisfito@ica.gov.co' . PHP_EOL;
//    $components->Log('log_' . $date1[0] . '.txt', $msg . "/" . $date . "/" . PHP_EOL);
    echo $msg;
}
?>

