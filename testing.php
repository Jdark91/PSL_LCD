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

<script>
	$(document).ready(function() {
		const cargarDato = () => {
			var size = Math.floor((Math.random() * 10));
			var value = Math.floor((Math.random() * 9999999));
			var valor = size+','+value;
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
			if (size == 0 || value == 0) {
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
			}else{
				return false;
			}
		}

		cargarDato();

	});
</script>
</body>
</html>
