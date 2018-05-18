<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Prueba</title>
	<style>
		.container{
			position: relative;
		    width: 8%;
		    display: inline-block;
		}
	</style>
</head>
<body>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<?php if (!isset($_GET['numero'])): ?>
	<script>
		$(document).ready(function() {
			const cargarDato = () => {
				var valor = prompt("Ingrese el número");
				$.ajax({
					url: 'lib.php',
					type: 'POST',
					data: {'numero': valor},
				})
				.done(function(data) {
					$( "body" ).append(data);
				})
				.fail(function() {
					console.log("error");
				})
				if (valor == "0,0" || valor == null) {
					valor = 0;
					return valor;
				}else{
					ciclo(valor);
				}

			}

			const ciclo = (data) => {
				if (data !== 0) {
					setTimeout(function() {
						cargarDato();
					}, 100);
				}
			}

			let data = cargarDato();

		});
	</script>
<?php else: 
		require 'lib.php';
		$numero = (isset($_GET['numero']) ? $_GET['numero'] : 0); 
		$pantalla = new PantallaLED($numero);
?>

<?php endif ?>
</body>
</html>