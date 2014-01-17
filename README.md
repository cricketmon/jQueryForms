# Structure Form

<code>

	<div id="demoform">
		<h1>title</h1>

		<div class="box success">blank</div>

		<form method="post">
			<input type="text" name="email" class="email" value="" />
			<input type="checkbox" name="boletin" id="boletin" value="1" checked> Deseo recibir el bolet&iacute;n de "empresa" en mi correo electrónico.
			<input type="hidden" name="lang" class="lang" value="es" />
			<input type="submit" class="submit" value="send" />
		</form>
	</div>

</code>

# General Specifications

> Validar campos vacios. Mensaje de error arrojados en globos de texto.
> Validar correo electronico. Mensaje de error arrojados en globos de texto.
> Si el campo boletin esta marcado, registra el correo en BENCHMARK.

> Si se va a utilizar en html libre, las rutas deben ser sin slash al inicio "php/mailhandler.php"
> Si se va a utilizar en friendlyURI, las rutas deben llevar slash al inicio "/php/mailhandler.php"

[mailto](vaio_nestor@yahoo.com)