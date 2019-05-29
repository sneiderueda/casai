<?php

include_once 'Dialog.php';
require("PHPMailer-master/class.phpmailer.php");
require("PHPMailer-master/class.smtp.php");

class Components {

    private $conect;
    protected $error = 'error';
    private static $date = null;
    private static $dateHead = null;

    public static function getDate($timeZone = null, $varDate = null) {
        if (is_null($timeZone)) {
            date_default_timezone_set('America/Bogota');
            return self::$date = date('Y-m-d H:i:s');
        } else {
            date_default_timezone_set($timeZone);
            if (is_null($varDate))
                return self::$date = date('Y-m-d H:i:s');
            else
                return self::$date = date($varDate);
        }
    }
    public static function getDateHead($place = null) {
        $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        if (is_null($place)) {
            return self::$dateHead = 'Bogot&aacute; D.C. '.$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');
        }else{
            return self::$dateHead = $place.' '.$dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');            
        }
        
    }

    public function sendRsForMail($rs = null, $mails = null, $mailsBCC = null, $subject = null, $msg = null, $attachment = null) {
        $mail = new PHPMailer();
        /**MAILS FROM ICA**/
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = "smtp.office365.com";
        $mail->Port = 587;
        $mail->Username = "sisfito@ica.gov.co";
        $mail->Password = "Sirin201413";
        $mail->From = 'sisfito@ica.gov.co';
        $mail->FromName = "ICA - TRAMITES";
        //**************************/
        $mail->Subject = $subject;
        $mail->CharSet='UTF-8';
        //**************************/
        if (is_array($attachment)) {
            foreach ($attachment as $k => $v):
                $mail->AddAttachment($v);
            endforeach;
        }
        else {
            $mail->AddAttachment($attachment);
        }
        //**************************/
        if (is_array($mails)) {
            foreach ($mails as $k => $v):
                $mail->AddAddress($v);
            endforeach;
        }
        else {
            $mail->AddAddress($mails);
        }
        //**************************/
        if (is_array($mailsBCC)) {
            foreach ($mailsBCC as $k => $v):
                $mail->AddBCC($v);
            endforeach;
        }
        else {
            $mail->AddBCC($mailsBCC);
        }
        //**************************/                
        if (is_null($msg)) {
            $message = $this->createMsgMail($rs);
        } else {
            $message = $msg;
        }
        $mail->IsHTML(true);
        $mail->Body = $message;
        $send = $mail->Send();
        if ($send) {
            return true;
        } else {
            return $mail->ErrorInfo;
        }
    }

    public function createMsgMail($rs) {
        
    }

    public function Log($fileName = null, $msg = null) {
        if (!is_dir('../Logs/')) {
            mkdir('../Logs/');
        }
        if (!file_exists("../Logs/" . $fileName))
            return file_put_contents("../Logs/" . $fileName, $msg, FILE_APPEND);
        else
            return file_put_contents("../Logs/" . $fileName, $msg, FILE_APPEND);
    }

}

?>
