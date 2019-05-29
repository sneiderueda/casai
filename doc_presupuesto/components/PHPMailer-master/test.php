<?php

//include './PHPMailer-master/class.phpmailer.php';
//
//$mail = new PHPMailer();
//
//$mail->Username = 'test@cablemas.co';
//$mail->Password = "Antares@64";
//$mail->From = 'test@cablemas.co';
//$mail->FromName = "PRUEBA CABLE MAS";
//$mail->Subject = "PRUEBAAAAAA";
//$mail->addAddress('kusanagimilo@gmail.com');
//$mail->isHTML(true);
//$mail->Body = "esto es una prueba para el hp del jorge ";
//$envio = $mail->send();
//
//var_dump($envio);

include 'PHPMailer-master/class.phpmailer.php';
$mail = new PHPMailer();
$mail->From = 'test@cablemas.co'; // Mail de origen
$mail->FromName = 'Antares'; // Nombre del que envia
$mail->AddAddress('kusanagimilo@gmail.com'); // Mail destino, podemos agregar muchas direcciones
$mail->AddReplyTo('test@cablemas.co'); // Mail de respuesta

$mail->WordWrap = 50; // Largo de las lineas
$mail->IsHTML(true); // Podemos incluir tags html
$mail->Subject = "Consulta formulario Web: fsdfds";
$mail->Body = "Nombre: nom \n<br />Email: email \n<br />Tel: tel \n<br />Mensaje: info \n<br />";
$mail->AltBody = strip_tags($mail->Body); // Este es el contenido alternativo sin html


$mail->Mailer = "smtp";
$mail->Host = "ssl://mint1.noc401.com";
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "test@cablemas.com"; // SMTP username
$mail->Password = "burmaUY123456"; // SMTP password


$mail->Send();

var_dump($mail);

//$mail->Host = 'localhost';
//
//$mail->IsSMTP(); // vamos a conectarnos a un servidor SMTP
//$mail->Host = "mint1.noc401.com"; // direccion del servidor
//$mail->SMTPAuth = true; // usaremos autenticacion
//$mail->Username = "test@cablemas.co"; // usuario
//$mail->Password = "Antares@64"; // contraseña


