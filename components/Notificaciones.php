<?php

include_once 'Components.php';

Class Notificaciones {

    public $msg = null;

    public function header($infoTitle, $html) {
        $this->msg = <<<MSG
   <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="http://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n $infoTitle<br>
			<span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="http://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;text-align:center;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:0px;padding-top:0px;padding-bottom:0px">
				<img alt="Logo Civico" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:75%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
			</td>
			<td bgcolor="#ffffff" >
				$html	
			</td>
		</tr>
MSG;
        $this->msg.=$this->footer();
        return $this->msg;
    }

    public function envioClaveUsuarioNuevo($namesUser, $user, $pass,$identificacion) {
        $fechacabecera = Components::getDateHead();
        $this->msg = <<<MSG
   <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="http://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n Contrase&ntilde;a de acceso<br>
			<span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="http://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;text-align:center;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:0px;padding-top:0px;padding-bottom:0px">
				<img alt="Logo Civico" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:75%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
			</td>
			<td bgcolor="#ffffff" >
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br>
				<span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>
                                <span style="font-weight:300;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px">El <b>instituto colombiano agropecuario</b> pensando en los ciudadanos ha desarrollado el nuevo servicio en l&iacute;nea de tr&aacute;mites, que pretende mantenerlo informado sobre todas las solicitudes que realice a trav&eacute;s de este medio con nosotros.<br><br>Por lo anterior, le estamos enviando por este medio de manera confidencial la clave de ingreso.<br><br><b>(Se recomienda cambiarla peri&oacute;dicamente)</b>.<br><br>Su usuario est&aacute; identificado con la siguiente informaci&oacute;n :</span><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px">Su usuario es: <strong>$user</strong></span><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px">Su clave de sistema es: <strong>$pass</strong></span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                                <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>   	
			</td>
		</tr>
MSG;
        $this->msg.=$this->footer();
        return $this->msg;
    }

    public function forgotYourPasword($namesUser = null, $link = null,$identificacion = null) {
        $i = 0;
        $fechacabecera = Components::getDateHead();
        $this->msg = <<<MSG
   <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="http://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n Restablecer Contrase&ntilde;a<br>
			<span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="http://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;text-align:center;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:0px;padding-top:0px;padding-bottom:0px">
				<img alt="Logo Civico" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:75%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
			</td>
			<td bgcolor="#ffffff" >
                        <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
                        <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br>
		        <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                        <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>
			<span style="font-weight:300;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px"> Hemos recibido una petici&oacute;n para restablecer la contrase&ntilde;a de su cuenta.</span><br>				
			<span style="font-weight:300;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px">Si realiz&oacute; esta petici&oacute;n, haga clic en el siguiente enlace, de lo contrario ignore este mensaje.</span><br>
			<span style="font-weight:400;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px"><strong>Enlace para restablecer tu contrase&ntilde;a</strong><br><br><a href="$link"> Restablecer contrase&ntilde;a </a></span><br>
                        <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
                        <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                        <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>	
			</td>
		</tr>
MSG;
        $this->msg.=$this->footer();
        return $this->msg;
    }

    public function changePassword($namesUser, $user,$identificacion) {
        $fecha = Components::getDate();
        $fechacabecera = Components::getDateHead();
        $this->msg = <<<MSG
   <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="http://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n Cambio Contrase&ntilde;a<br>
			<span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="http://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;text-align:center;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:0px;padding-top:0px;padding-bottom:0px">
				<img alt="Logo Civico" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:75%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
			</td>
			<td bgcolor="#ffffff" >
				<span style="font-weight:700;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
                                <span style="font-weight:700;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br>
				<span style="font-weight:700;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                                <span style="font-weight:700;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>
				<span style="font-weight:400;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px"> Esta comunicaci&oacute;n es para notificarle que se han realizado cambios en su cuenta, los cuales hemos recibido de su parte a trav&eacute;s del aplicativo.</span><br>
				<span style="font-weight:400;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px">En el evento que la informaci&oacute;n aqu&iacute; presentada no corresponda a lo solicitado por usted, le agradecemos informarnos de inmediato a nuestras l&iacute;neas <strong>3323700 - 2884800</strong>, L&iacute;nea gratuita gacional <strong>018000124410</strong>, o al correo electr&oacute;nico <strong>soporte.tecnico@ica.gov.co</strong></span><br>
                                <span style="font-weight:400;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:50px;padding-bottom:0px;padding-left:0px">Notificaci&oacute;n aplicativo<br><strong>Tipo de cambio:</strong> clave de acceso aplicativo<br><strong>Usuario:</strong> $user<br><strong>Fecha cambio:</strong> $fecha</strong><br></span><br>
                                <span style="font-weight:400;font-size:14px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                                <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>	
			</td>
		</tr>
        
MSG;
        $this->msg.=$this->footer();
        return $this->msg;
    }

        /*
     * Descripcion : Se crea funcion para la plantilla del correo validacion de documentos
     * Creado Por : Jennifer Cabiativa
     * Fecha de creación : 28 de Julio de 2016 
     * Empresa : ICA
     */
    public function ValidacionDocumentos($namesUser,$table,$identificacion,$numTramite) {
        $fechacabecera = Components::getDateHead();
        $fecha = Components::getDate();
        $this->msg = <<<MSG
    <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="https://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n validaci&oacute;n documentos<br>
                                <span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="https://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>			
			<td colspan="2" bgcolor="#ffffff" >
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br> 
				<span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">El <strong>instituto colombiano agropecuario</strong> pensando en los ciudadanos ha desarrollado el nuevo servicio en l&iacute;nea de tr&aacute;mites, que pretende mantenerlo informado sobre todas las solicitudes que realice a trav&eacute;s de este medio con nosotros.<br><br>Por lo anterior, le estamos enviando por este medio el &uacute;ltimo cambio que su entidad ha registrado en el instituto,  bajo el n&uacute;mero de tr&aacute;mite <b>$numTramite</b> de <b>$fecha</b>.</span><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">$table </span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                                <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>          
			</td>
		</tr>
MSG;
        $this->msg.= $this->footer();
        return $this->msg;
    }
    /*
     * Descripcion : Se crea plantilla correo visita tramite
     * Creado Por : Nicolas Velasquez
     * Fecha de creación : 24 de Octubre de 2016 
     * Empresa : ICA
     */
    public function envioDatosVisitaProgramada($namesUser,$table,$identificacion,$numTramite) {
        $fechacabecera = Components::getDateHead();
        $fecha = Components::getDate();
        $this->msg = <<<MSG
    <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="https://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n programaci&oacute;n visita<br>
                                <span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="https://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>			
			<td colspan="2" bgcolor="#ffffff" >
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br> 
				<span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">El <strong>instituto colombiano agropecuario</strong> pensando en los ciudadanos ha desarrollado el nuevo servicio en l&iacute;nea de tr&aacute;mites, que pretende mantenerlo informado sobre todas las solicitudes que realice a trav&eacute;s de este medio con nosotros.<br><br>Por lo anterior, le estamos enviando por este medio el &uacute;ltimo cambio que su entidad ha registrado en el instituto,  bajo el n&uacute;mero de tr&aacute;mite <b>$numTramite</b> de <b>$fecha</b>.</span><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">$table </span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                                <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>          
			</td>
		</tr>
MSG;
        $this->msg.= $this->footer();
        return $this->msg;
    }
    /*
     * Descripcion : Se crea plantilla correo concepto tramite
     * Creado Por : Nicolas Velasquez
     * Fecha de creación : 24 de Octubre de 2016 
     * Empresa : ICA
     */
    public function envioDatosConceptoTramite($namesUser,$table,$identificacion,$numTramite) {
        $fechacabecera = Components::getDateHead();
        $fecha = Components::getDate();
        $this->msg = <<<MSG
    <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="https://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n concepto<br>
                                <span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="https://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>			
			<td colspan="2" bgcolor="#ffffff" >
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br> 
				<span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">El <strong>instituto colombiano agropecuario</strong> pensando en los ciudadanos ha desarrollado el nuevo servicio en l&iacute;nea de tr&aacute;mites, que pretende mantenerlo informado sobre todas las solicitudes que realice a trav&eacute;s de este medio con nosotros.<br><br>Por lo anterior, le estamos enviando por este medio el &uacute;ltimo cambio que su entidad ha registrado en el instituto,  bajo el n&uacute;mero de tr&aacute;mite <b>$numTramite</b> de <b>$fecha</b>.</span><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">$table </span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
                                <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                                <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>          
			</td>
		</tr>
MSG;
        $this->msg.= $this->footer();
        return $this->msg;
    }
    /*
     * Descripcion : Se crea plantilla correo radicacion tramite
     * Creado Por : Nicolas Velasquez
     * Fecha de creación : 12 de Octubre de 2016 
     * Empresa : ICA
     */
    public function radicacionTramite($namesUser,$table,$numTramite,$identificacion) {
        $fecha = Components::getDate();
        $fechacabecera = Components::getDateHead();
        $mensaje=<<<mess
                <table bgcolor="#ededed" border="0" cellpadding="0" cellspacing="0" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;width:600px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;border:0px;border-spacing:0px">
	<tbody>
		<tr>
			<td width="180px" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:8px;text-align:left">
				<a>
				<img alt="Logo Sisfito" src="https://sisfito.ica.gov.co/images/logo-ica-page-principal.png" style="max-width:100%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
				</a>
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:15px;font-weight:600; color:#5C8C33">Notificaci&oacute;n radicaci&oacute;n trámite<br>
			<span style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07"><i>Sistema de Información Trámites</i></span>			
			</td>
		</tr>
		<tr>
			<td colspan="2" style="margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:5px;padding-right:0px;padding-bottom:0px;padding-left:0px;min-height:20px">
				<img alt="Header" height="20" src="https://sisfito.ica.gov.co/images/content_top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="580">
			</td>
		</tr>
		<tr>
			<td bgcolor="#ffffff" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;text-align:center;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:0px;padding-top:0px;padding-bottom:0px">
				<img alt="Logo Civico" src="https://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:75%;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px" width="120">
			</td>
			<td bgcolor="#ffffff" >
				<span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">SERVICIO EN LÍNEA - INSTITUTO COLOMBIANO AGROPECUARIO.</span><br><br>
            <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$fechacabecera </span><br><br>
				<span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>Se&ntilde;or(es) $namesUser , </span>
                                <span style="font-weight:700;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px"><br>$identificacion , </span><br><br>           
            <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">El <strong>instituto colombiano agropecuario</strong> pensando en los ciudadanos ha desarrollado el nuevo servicio en l&iacute;nea de tr&aacute;mites, que pretende mantenerlo informado sobre todas las solicitudes que realice a trav&eacute;s de este medio con nosotros.<br><br>Por lo anterior, le estamos enviando por este medio el &uacute;ltimo cambio que su entidad ha registrado en el instituto,  bajo el n&uacute;mero de tr&aacute;mite <b>$numTramite</b> de <b>$fecha</b>.</span><br>
            <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">$table </span><br><br>
            <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Le recordamos que esta direcci&oacute;n de e-mail es utilizada solamente para los env&iacute;os de la informaci&oacute;n mencionada, por favor no responda con consultas personales ya que no podr&aacute;n ser respondidas, cualquier informaci&oacute;n adicional relacionada con la presente comunicaci&oacute;n pueden obtenerla en el tel&eacute;fono 3323700.</span><br><br>
            <span style="font-weight:400;font-size:16px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">Confiamos que esta informaci&oacute;n ser&aacute; oportuna, importante y de gran utilidad para su empresa.</span><br><br>
                                <span style="font-style:italic;font-size:12px;text-align:left;display:block;color:#232333;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:10px;padding-right:50px;padding-bottom:0px;padding-left:0px">"Este es un mensaje de car&aacute;cter confidencial de la <b>Instituto Colombiano Agropecuario</b>. Si usted no es el destinatario del mismo o no est&aacute; autorizado para recibir este mensaje en nombre del destinatario, abst&eacute;ngase de usar, copiar, divulgar o en cualquier otra forma esta informaci&oacute;n. Las opiniones o informaci&oacute;n de tipo personal o no directamente relacionadas con los asuntos del <b>Instituto Colombiano Agropecuario</b> que contenga este mensaje no se deben entender como respaldadas por esta. Si recibi&oacute; este mensaje por error por favor comun&iacute;quese en forma inmediata con su remitente."</span><br><br>          
			</td>
		</tr>
mess;
        $this->msg.=$mensaje;
        $this->msg.=$this->footer();
        return $this->msg;
        
    }
    public function footer() {
        $fecha = Components::getDate();
        $msg = <<<MSG
                <tr>
			<td bgcolor="#ffffff" colspan="2" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:248px;padding-top:0px;padding-bottom:0px;text-align:center;min-height:41px">
				<img alt="ICA Icon" height="41" src="http://sisfito.ica.gov.co/images/logoica-top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="77">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:248px;padding-top:0px;padding-bottom:0px;text-align:center;min-height:36px;vertical-align:top">
				<img alt="ICA Icon" height="36" src="http://sisfito.ica.gov.co/images/logoica-bottom_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="77">
			</td>
		</tr>
		<tr>
			<td width="180px" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:10px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07">
			Mensaje generado automaticamente favor no responder: <br>$fecha
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:13px;font-weight:500; color:#545454">
                                <span style="font-weight:700;font-size:15px;text-align:right;display:block;color:#5C8C33;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">Soporte Plataforma </span>
                                <span style="text-align:right;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><img alt="Logo" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="20"/> soporte.tecnico@ica.gov.co </span>
                                <span style="text-align:rigth;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">
                                        <img alt="Logo" src="http://sisfito.ica.gov.co/images/telefono_notificacion.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="25"/> 3323700 - 2884800 Ext 1111</span>
                                <span style="text-align:rigth;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><img alt="Logo" src="http://sisfito.ica.gov.co/images/linea-nacional.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="20"/> L&iacute;nea Gratuita Nacional 018000124410</span>								
			</td>
		</tr>
	</tbody>
</table>
MSG;
        return $msg;
    }

    public function footer_tables() {
        $fecha = Components::getDate();
        $msg = <<<MSG
                <tr>
			<td bgcolor="#ffffff" colspan="2" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:46%;padding-top:0px;padding-bottom:0px;text-align:center;min-height:41px">
				<img alt="ICA Icon" height="41" src="http://sisfito.ica.gov.co/images/logoica-top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="77">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:46%;padding-top:0px;padding-bottom:0px;text-align:center;min-height:36px;vertical-align:top">
				<img alt="ICA Icon" height="36" src="http://sisfito.ica.gov.co/images/logoica-bottom_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="77">
			</td>
		</tr>
		<tr>
			<td width="180px" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:10px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07">
			Mensaje generado automaticamente favor no responder: <br>$fecha
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:13px;font-weight:500; color:#545454">
				<span style="font-weight:700;font-size:15px;text-align:right;display:block;color:#5C8C33;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">Soporte Plataforma </span>
                                <span style="text-align:right;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><img alt="Logo" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="20"/> soporte.tecnico@ica.gov.co </span>
                                <span style="text-align:rigth;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">
                                            <img alt="Logo" src="http://sisfito.ica.gov.co/images/telefono_notificacion.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="25"/> 3323700 - 2884800 Ext 1111</span>
                                <span style="text-align:rigth;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><img alt="Logo" src="http://sisfito.ica.gov.co/images/linea-nacional.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="20"/> L&iacute;nea Gratuita Nacional 018000124410</span>							
			</td>
		</tr>
	</tbody>
</table>
MSG;
        return $msg;
    }

    public function footer_notificacion_grillas() {
        $fecha = Components::getDate();
        $msg = <<<MSG
                <tr>
			<td bgcolor="#ffffff" colspan="2" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:46%;padding-top:0px;padding-bottom:0px;text-align:center;min-height:41px">
				<img alt="ICA Icon" height="41" src="http://sisfito.ica.gov.co/images/logoica-top_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="77">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-right:0px;padding-left:46%;padding-top:0px;padding-bottom:0px;text-align:center;min-height:36px;vertical-align:top">
				<img alt="ICA Icon" height="36" src="http://sisfito.ica.gov.co/images/logoica-bottom_notificacion.png" style="border:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px;display:block" width="77">
			</td>
		</tr>
		<tr>
			<td width="180px" style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:10px;padding-left:10px;text-align:left;vertical-align:middle;font-size:11px;font-weight:400; color:#D89C07">
			Mensaje generado automaticamente favor no responder: <br>$fecha
			</td>
			<td style="font-family:'HelveticaNeue','Helvetica',Helvetica,Arial,sans-serif;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:5px;padding-bottom:0px;padding-left:0px;text-align:right;vertical-align:middle;font-size:13px;font-weight:500; color:#545454">
				<span style="font-weight:700;font-size:15px;text-align:right;display:block;color:#5C8C33;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">Soporte SISFITO </span>
                                <span style="text-align:right;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><img alt="Logo" src="http://sisfito.ica.gov.co/images/mensaje_notificacion.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="20"/> soporte.tecnico@ica.gov.co </span>
                                <span style="text-align:rigth;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px">
                                            <img alt="Logo" src="http://sisfito.ica.gov.co/images/telefono_notificacion.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="25"/> 3323700 - 2884800 Ext 1111</span>
                                <span style="text-align:rigth;display:block;margin-top:0px;margin-bottom:0px;margin-left:0px;margin-right:0px;padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><img alt="Logo" src="http://sisfito.ica.gov.co/images/linea-nacional.png" style="max-width:100%;vertical-align:middle;margin-top:0px;margin-right:0px;margin-bottom:0px;margin-left:0px;padding-top:0px;padding-right:0px;padding-bottom:5px;padding-left:0px" width="20"/> L&iacute;nea Gratuita Nacional 018000124410</span>							
			</td>
		</tr>
	</tbody>
</table>
MSG;
        return $msg;
    }

}

?>
