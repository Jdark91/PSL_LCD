<?php
	class PantallaLED
	{
		#Variables

		private $numero;
		private $array_matriz;
		private $columnasTotales;
		private $filasTotales;
			
		#Inicializador

		function __construct($numero){
			$this->numero = $numero;
			$this->array_matriz = array();
			$this->columnasTotales = 0;
			$this->filasTotales = 0;
			$this->ImprimirLED();
		}

		#Imprimir Número LED

		private function ImprimirLED(){
			$numero = $this->SepararNumero();
			$this->columnasTotales = $numero[0]+2;
			$this->filasTotales = (2*$numero[0])+3;
			$this->CrearTabla($numero);
		}

		#Funciones internas 

		#Función que permite separar los datos ingresados
		private function SepararNumero(){
			$separacion = explode(',', $this->numero); #Separación de datos
			$this->ValidarNumero($separacion); #Valida que los datos estés correctos
			return $separacion;
		} 

		#Función que permite validar que los datos ingresados sean numéricos 
		private function ValidarNumero($separacion){
			if (!is_array($separacion) || count($separacion) != 2) {
				$this->Mensaje("Debe incluir tamaño y número ejemplo - (10,1000)");
			}

			foreach ($separacion as $key => $data) {
				#Valida que el dato sea numérico
				if (!is_numeric($data)) {
					$this->Mensaje("Los valores ingresados deben ser numéricos - ejemplo (10,1000)");
				}

				#Indica que el primer datos osea Size sea no sea menor de 0 o mayor de 10
				if ($key == 0) {
					if ($data < 0 || $data > 10) {
						$this->Mensaje("El tamaño debe ser mayor a 1 y menor a 10");
					}
				}

				#Indica que si alguna de las 2 variables se encuentra en 0 "Cierra el Programa"
				if ($data == 0) {
					$this->Mensaje("Cierre de Programa");
				}
			}
		}

		#Función para reutilizar los mensaje a mostrar
		private function Mensaje($mensaje){
			echo $mensaje;
			exit();
		}

		#Funcion para imprimir los datos en una tabla
		private function CrearTabla($data){
			$numero = str_split($data[1]); #convierte una dato string en array
			echo '<div class="contenedor" style="color:'.$this->rand_color().'">';
			foreach ($numero as $n => $valor) {
				$this->CrearMatrizNumerica($data[0], $valor);
				echo '<div class="container">';
					echo '<table>';
						for ($fila=0; $fila < $this->filasTotales; $fila++) {
							echo "<tr>";  
								for ($colum=1; $colum <= $this->columnasTotales; $colum++) {
									echo '<td>'; 
										foreach ($this->array_matriz[$valor] as $s => $val) {	
											if ($val['num'] == $fila.'-'.$colum) {
												echo $val['pos'];
											}
										}
									echo '</td>';
								}
							echo "</tr>"; 
						}
					echo '</table>';
				echo '</div>';
			}
			echo '</div>';
			echo '<div style="height: 30px"></div>';
		}

		#Función que organiza en un array los campos para imprimir según las coordenadas asignadas para cada número
		private function CrearMatrizNumerica($size, $num){
			$invertir_linea = false; #Variable de apoyo para invertir línea 2, 5 y 6  
			$cuatro = false; #Variable de apoyo para organizar las coordenadas del número 4
			$contador = 0; #Variable de apoyo para validar con condicionales especiales con ayuda de las anteriores
			$this->array_matriz[$num] = array(); #Resetea el array "matriz" 
			for ($fila=0; $fila < $this->filasTotales; $fila++) { 
				for ($colum=1; $colum <= $this->columnasTotales; $colum++) { 
					switch ($num) {
						#Creando coordenadas para el número 0 
						case 0:
								if ($fila == 0 || $fila == $this->filasTotales-1) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($colum === 1) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
										$this->array_matriz[$num][$fila.'-'.$this->columnasTotales]['num'] = $fila.'-'.$this->columnasTotales;
										$this->array_matriz[$num][$fila.'-'.$this->columnasTotales]['pos'] = '|';
									}
								}
							break;
						#Creando coordenadas para el número 1
						case 1:
								if ($colum == $this->columnasTotales) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
								}
							break;
						#Creando coordenadas para el número 2
						case 2:
								if ($fila == 0 || $fila == $this->filasTotales-1 || $fila == $this->columnasTotales-1) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($colum == $this->columnasTotales && !$invertir_linea) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
										$contador++;
									}

									if ($colum == 1 && $invertir_linea) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}
								}

								if ($contador == $size) {
									$invertir_linea = !$invertir_linea;
									$contador = 0;
								}

							break;
						#Creando coordenadas para el número 3
						case 3:
								if ($fila == 0 || $fila == $this->filasTotales-1 || $fila == $this->columnasTotales-1) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($colum == $this->columnasTotales) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}
								}

							break;
						#Creando coordenadas para el número 4
						case 4:
								if ($fila == $this->columnasTotales-1 && !$cuatro) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
									$contador++;
									if ($contador == $this->columnasTotales) {
										$cuatro = !$cuatro;
										$contador = 0 ;
										continue;
									}
								}else{
									if ($colum == $this->columnasTotales && !$cuatro || $colum == 1 && !$cuatro) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}

									if ($colum == $this->columnasTotales && $cuatro) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}
								}

							break;
						#Creando coordenadas para el número 5
						case 5:
								if ($fila == 0 || $fila == $this->filasTotales-1 || $fila == $this->columnasTotales-1) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($colum == 1 && !$invertir_linea) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
										$contador++;
									}

									if ($colum == $this->columnasTotales && $invertir_linea) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}
								}

								if ($contador == $size && $colum == $this->columnasTotales) {
									$invertir_linea = !$invertir_linea;
									$contador = 0;
								}

							break;
						#Creando coordenadas para el número 6
						case 6:
								if ($fila == 0 || $fila == $this->filasTotales-1 || $fila == $this->columnasTotales-1) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($colum == 1 && !$invertir_linea) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
										$contador++;
									}

									if ($colum == $this->columnasTotales && $invertir_linea || $colum == 1 && $invertir_linea) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}
								}

								if ($contador == $size && $colum == $this->columnasTotales) {
									$invertir_linea = !$invertir_linea;
									$contador = 0;
								}

							break;
						#Creando coordenadas para el número 7
						case 7:
								if ($fila == 0) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($colum == $this->columnasTotales) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
									}
								}

							break;
						#Creando coordenadas para el número 8
						case 8:
								if ($fila == 0 || $fila == $this->filasTotales-1 || $fila == $this->columnasTotales-1) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';

								}else{
									if ($colum == 1) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';
										$this->array_matriz[$num][$fila.'-'.$this->columnasTotales]['num'] = $fila.'-'.$this->columnasTotales;
										$this->array_matriz[$num][$fila.'-'.$this->columnasTotales]['pos'] = '|';
									}
								}
							break;
						#Creando coordenadas para el número 9
						case 9:
								if ($fila == 0) {
									$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
									$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
								}else{
									if ($fila == $this->columnasTotales-1 && !$cuatro) {
										$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
										$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '-';
										$contador++;
										if ($contador == $this->columnasTotales) {
											$cuatro = !$cuatro;
											$contador = 0 ;
											continue;
										}
									}else{
										if ($colum == $this->columnasTotales && !$cuatro || $colum == 1 && !$cuatro) {
											$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
											$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';

										}

										if ($colum == $this->columnasTotales && $cuatro) {
											$this->array_matriz[$num][$fila.'-'.$colum]['num'] = $fila.'-'.$colum;
											$this->array_matriz[$num][$fila.'-'.$colum]['pos'] = '|';

										}
									}
								}
							break;
					}
				}
			}
		}

		private function rand_color() {
		    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
		}
	}
	if (isset($_POST['numero'])) {
		$numero = $_POST['numero'];
		$pantalla = new PantallaLED($numero);
	}
	
?>