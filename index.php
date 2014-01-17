
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>

	<meta charset="utf-8">

	<title>jQuery Forms</title>
	<meta name="viewport" content="width=device-width">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="Description Here">

	<!--CSS-->
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	
	<!--Javascript-->
	<script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


	<script type='text/javascript' src="js/jquery.forms.js"></script>

</head>

<body>
	<!--Message Form Start-->
	<div class="blog-comments">
		<div id="contactForm">
			<h1>Contáctanos </h1>

			<div class="box success">blank</div>

			<form method="post">

				<fieldset>
					<h5>Nombre <span class="color_3">*</span> <br><input type="text" name="name" class="name comments-input" /></h5>

					<h5>E-mail <span class="color_3">*</span> <br><input type="email" name="email" class="email comments-input" /></h5>

					<h3>Su mensaje <span class="color_3">*</span><br><textarea name="message" cols="15" rows="5" class="message comments-text-area"></textarea></h3>

					<h3><input type="checkbox" name="boletin" id="boletin" value="1" checked> Deseo recibir el bolet&iacute;n de Casa Iguana en mi correo electrónico.</h3>

					<h4>
						<input type="hidden" value="es" name="lang" class="lang" />
						<input type="submit" value="Enviar" class="submit form-submit"/>
					</h4>
				</fieldset>

			</form>

		</div>
	</div>
	<!--Message Form End-->


</body>
</html>