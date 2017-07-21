<?php
/* 
//  cricket ( )
//  creado bajo el techo de __Club Sandwich Co__ el 2014-01-16
//  actualizado el xxxx-xx-xx
//  nestor arroba club sandwich punto eme equis
//  habiendo dicho eso, bienvenido al codigo
*/  


define('webName', 'jQuery Forms');


/* Herramientas para validacion y proceso de la informacion */
class _dpDataTools
{
	/**
	* @return cadena de texto escapada la inyeccion */
	function basicXSS($value) {return htmlentities(stripslashes(strip_tags(trim($value))),ENT_QUOTES,'UTF-8');}


	/**
	* @return string | id del field si un campo esta vacio | 0 si no hay campos vacios */
	function testEmptyField() {
		foreach ($_POST as $key => $value) {
			$ignoreField = '$,' . $this->fields;
			$ignoreField = strpos($ignoreField, $key);

			if (!$ignoreField) {
				$temp = $this->basicXSS($value);
				
				if ( is_array($temp) ) {
					foreach ($temp as $keyA => $valueA) {
						if (empty($valueA) || $valueA == '0') return $keyA;
					}
				} else {
					if (empty($temp) || $temp == '0') return $key;
				}
			}
		}
		
		return '' . $this->empty;
	}
	

	/**
	* @return true si es valido el telefono */
	function testTel($value) { return preg_match('/^(\(?[0-9]{3,3}\)?|[0-9]{3,3}[-. ]?)[ ][0-9]{3,3}[-. ]?[0-9]{4,4}$/', $value); }


	/**
	* @return true si es valido el e-mail */
	function testEmail($value) { return filter_var($value, FILTER_VALIDATE_EMAIL); }
}


/* Proceso para formularios */
class _dpForm extends _dpDataTools
{
	var $to,$Bcc,$fields,$empty;
	
	
	function __construct() {
		$this->to = '';
		$this->Bcc = '';
		$this->fields = '';
		$this->empty = 0;
	}


	function process() {
		$this->basicXSS(extract($_POST));
		$premark = '<span class="color_3">*</span> ';
		$body = '';

		/* configuracion de mensajes de alerta */
		switch ($lang) {
			case 'en':
			$error_field = '* This field is required.';
			$error_mail = '* This is not a valid address.';
			$error_send = 'Failed to send your message. Please try again.';
			$success = 'Your message has been sent successfully. <br /> Thank you for getting in touch with '. webName .'.';
			$bm_msg = 'Soon you\'ll receive a confirmation message to "' . $email . '" to continue your subscription to our newsletter.';
			break;
			
			case 'es':
			$error_field = '* Este campo es requerido.';
			$error_mail = '* Est&aacute; direcci&oacute;n no es v&aacute;lida.';
			$error_send = 'Ha ocurrido un error al enviar tu mensaje. Por favor intenta nuevamente.';
			$success = 'Tu mensaje ha sido enviado satisfactoriamente. <br /> Gracias por contactar a '. webName .'.';
			$bm_msg = 'En breve recibirás un mensaje de confirmación en "' . $email . '" para continuar tu suscripci&oacute;n a nuestro bolet&iacute;n de noticias.';
			break;
		}

		if ($this->testEmptyField() == '0') {
			
			if ($this->testEmail($email)) {
				$headers = "From: $email\nBcc: $this->Bcc\nContent-Type: text/html; charset=UTF-8";
				$subject = webName .' | Formulario de Contacto'; /* Empresa | Titulo del formulario */

				$body .= '<b>Nombre:</b> '.$name.'<br />';
				$body .= '<b>Email:</b> '.$email.'<br />';
				
				$body .= '<b>Mensaje</b>:<br />';
				$message = preg_replace('/\n/','<br />',$message);
				$message = preg_replace('/ /','&nbsp;', $message);
				$body .= $message;

				$body .= '<br /><br />';
				$body .= '--------------------<br />';
				$body .= '<b><a href="http://digital.org.mx" title="We Will">Digital Performing</a> &raquo; ContactForm[BETA]</b>';

				if(@mail($this->to, $subject, $body, $headers)) {
					if ($boletin == '1'){
						/*_____Benchmark*/
						error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
						require_once 'XML/RPC2/Client.php'; 

						try {
							$client = XML_RPC2_Client::create("http://api.benchmarkemail.com/1.0/");
							/*echo $token = $client->login("Casa Iguana", "c*ign*2014");*/
							$token = 'e8030280fe7c46f6ba967047ccd44745';

							/*$contactList = $client->listGet($token, "", 1, 100, "", "");*/
							/*echo $contactList[0]['id'];*/
							$listID = '2028046';

							$rec1['email'] = $email;
							$rec = array($rec1);

							$result = $client->listAddContactsOptin($token, $listID, $rec, '1');
						} catch (XML_RPC2_FaultException $e){
							echo $e->getFaultString() ."(" . $e->getFaultCode(). ")";
						}
						/*_____Benchmark*/
						
						$success = $success . '<br /><br />' . $premark . $bm_msg;
					}
			        
			        echo json_encode(array('refer' => '1', 'alert' => $premark . $success)); /*email success*/
			    } else {
			    	echo json_encode(array('refer' => 'die', 'alert' => $premark . $error_send)); /*email error*/
			    }
			} else {
				echo json_encode(array('refer' => '0', 'alert' => $error_mail, 'field' => 'email')); /*wrong email address*/
			}
		} else {
			echo json_encode(array('refer' => '0', 'alert' => $error_field, 'field' => $this->testEmptyField())); /*empty required fields*/
		}
	}

	function __destruct() {}
}


if (@$_POST['hungry'] && isset($_POST['lang'])) {
	$_dpForm = new _dpForm;

	$_dpForm->to = 'ceo@digital.org.mx,t.vargas@digital.org.mx';					/*destinatario*/
	$_dpForm->Bcc = 'n.ramirez@digital.org.mx';										/*con copia*/
	$_dpForm->fields = '';			 												/*campos del form que no son obligatorios ej. nombre,email*/

	$_dpForm->process();

} elseif (!empty($_SERVER['SCRIPT_FILENAME']) && 'MailHandler.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!'); /* Intrusos a volar */
}
?>
