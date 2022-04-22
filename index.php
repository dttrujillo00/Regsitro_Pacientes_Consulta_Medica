<?php

include_once 'conexion.php';
include_once 'functions/funciones.php';

//LEER
$sql_leer = 'SELECT * FROM pacientes';
$gsent = $pdo->prepare($sql_leer);
$gsent->execute();
$resultado = $gsent->fetchAll();

/**TRAER EL PACIENTE A EDITAR PARA LLENAR LOS CAMPOS DE EDITAR */
if ($_GET) {
	$id = $_GET['id'];
	$sql_unico = 'SELECT * FROM pacientes WHERE id=?';
	$gsent_unico = $pdo->prepare($sql_unico);
	$gsent_unico->execute(array($id));
	$resultado_unico = $gsent_unico->fetch();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/fontello.css" >

	<title>Consulta Médica</title>
</head>
<body>

	
	<div class="imagen-fondo">
		<header class="site-header">
			
			<h1>Consulta Médica</h1>
			
		</header>
		
		<div class="form-container contenedor">
				<!--CUADRO DE BÚSQUEDA-->
				<h2 class="text-center">Cuadro de Búsqueda</h2>
				
				<form method="post" action="buscar.php" class="campos-container">
					<div class="campo">
						<input type="text" name="buscar_nombre" id="buscar_nombre" class="input-buscar" placeholder="Nombre...">
						<input type="hidden" name="input_id_nombre" value="1">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_sexo" id="buscar_sexo" class="input-buscar" placeholder="Sexo...">
						<input type="hidden" name="input_id_sexo" value="2">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_grupo" id="buscar_grupo" class="input-buscar" placeholder="Grupo Disp...">
						<input type="hidden" name="input_id_grupo" value="3">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_direccion" id="buscar_direccion" class="input-buscar" placeholder="Dirección...">
						<input type="hidden" name="input_id_direccion" value="4">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_edad" id="buscar_edad" class="input-buscar" placeholder="Edad...">
						<input type="hidden" name="input_id_edad" value="9">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_n_educacional" id="buscar_n_educacional" class="input-buscar" placeholder="Nivel educacional...">
						<input type="hidden" name="input_id_n_educacional" value="6">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_manzana" id="buscar_manzana" class="input-buscar" placeholder="Manzana...">
						<input type="hidden" name="input_id_manzana" value="7">
					</div>
	
					<div class="campo">
						<input type="text" name="buscar_diagnostico" id="buscar_diagnostico" class="input-buscar" placeholder="Diagnóstico...">
						<input type="hidden" name="input_id_diagnostico" value="8">
					</div>
	
					<div class="div-button">
						<button type="submit" class="btn btn-success">Buscar</button>
					</div>
	
				</form>
		</div>
	
			
				<div class="form-container contenedor">
					<?php if(!$_GET): ?>
						<h2 class="text-center" id="agregar">Agregar Paciente</h2>
					<form class="campos-container form-agregar">
	
						<div class="campo-agregar-editar column-7">
							<label for="nombre_apellido">Nombre y Apellido</label>
							<input  class="" type="text" name="nombre_apellido" id="nombre_apellido">
						</div>
	
						<div class="campo-agregar-editar column-2">
							<label for="sexo" class="">Sexo</label>
							<select name="sexo" id="sexo" class="">
								<option value="F">F</option>
								<option value="M">M</option>
							</select>
						</div>
	
						<div class="campo-agregar-editar column-3">
							<label for="fecha_nacimiento" class="">Fecha de nacimiento</label>
							<input  class="" type="text" name="fecha_nacimiento" id="fecha_nacimiento">
						</div>
	
						<div class="campo-agregar-editar column-3">
							<label for="nivel_educacional" class="">Nivel educacional</label>
							<input  class="" type="text" name="nivel_educacional" id="nivel_educacional">
						</div>
	
						<div class="campo-agregar-editar column-4">
							<label for="direccion">Dirección</label>
							<input  class="" type="text" name="direccion" id="direccion">
						</div>

						<div class="campo-agregar-editar column-2">
							<label for="grupo_disp" class="">Grupo Disp.</label>
							<select name="grupo_disp" id="grupo_disp" class="">
									<option value="1">I</option>
									<option value="2">II</option>
									<option value="3">III</option>
									<option value="4">IV</option>
							</select>
						</div>
	
						<div class="campo-agregar-editar column-3">
							<label for="manzana">Manzana</label>
							<input  type="text" name="manzana" id="manzana" class="">
						</div>
	
						<div class="campo-agregar-editar column-12">
							<label for="diagnostico">Diagnóstico</label>
							<input name="diagnostico" id="diagnostico" class="" type="text">
						</div>
	
						<div class="column-2 div-button">
							<button class="btn btn-success" id="btn_agregar">Agregar</button>
						</div>
	
					</form>
					<?php endif ?>
				</div>
	
				<div class="form-container contenedor">
					<?php if($_GET): ?>
						<h2 class="text-center" id="editar">Editar Paciente</h2>
					<form class="campos-container form-editar" method="GET" action="editar.php">
	
						<div class="column-7 campo-agregar-editar">
							<label for="nombre_apellido">Nombre y Apellido</label>
							<input value="<?php echo $resultado_unico['nombre_apellido'] ?>" class="" type="text" name="nombre_apellido" id="nombre_apellido">
						</div>
	
						<div class="column-2 campo-agregar-editar">
						<label for="sexo" class="">Sexo</label>
							<select name="sexo" id="sexo" class="">
								<option value="<?php if($resultado_unico['sexo'] == "F"){
									echo "F";
								}else{
									echo "M";
								} ?>"><?php if($resultado_unico['sexo'] == "F"){
									echo "F";
								}else{
									echo "M";
								} ?></option>
								<option value="<?php if($resultado_unico['sexo'] == "F"){
									echo "M";
								}else{
									echo "F";
								} ?>"><?php if($resultado_unico['sexo'] == "F"){
									echo "M";
								}else{
									echo "F";
								} ?></option>
							</select>
						</div>

						<div class="column-3 campo-agregar-editar">
							<label for="fecha_nacimiento" class="">Fecha de nacimiento</label>
							<input value="<?php echo $resultado_unico['fecha_nacimiento'] ?>" class="" type="text" name="fecha_nacimiento" id="fecha_nacimiento">
						</div>

						<div class="column-3 campo-agregar-editar">
							<label for="nivel_educacional">Nivel educacional</label>
							<input value="<?php echo $resultado_unico['nivel_educacional'] ?>" class="" type="text" name="nivel_educacional" id="nivel_educacional">
						</div>
	
						<div class="column-4 campo-agregar-editar">
							<label for="direccion">Dirección</label>
							<input value="<?php echo $resultado_unico['direccion'] ?>" class="" type="text" name="direccion" id="direccion">
						</div>
	
						<?php
						$I = null;
						$II = null;
						$III = null;
						$IV = null;
						$I1 = null;
						$II2 = null;
						$III3 = null;
						$IV4 = null;
						switch ($resultado_unico['grupo_disp']) {
							case 1:
								$I = "I";
								$I1 = 1;
								$II = "II";
								$II2 = 2;
								$III = "III";
								$III3 = 3;
								$IV = "IV";
								$IV4 = 4;
								break;
							case 2:
								$I = "II";
								$I1 = 2;
								$II = "I";
								$II2 = 1;
								$III = "III";
								$III3 = 3;
								$IV = "IV";
								$IV4 = 4;
								break;
	
								case 3:
									$I = "III";
									$I1 = 3;
									$II = "II";
									$II2 = 2;
									$III = "I";
									$III3 = 1;
									$IV = "IV";
									$IV4 = 4;
									break;
	
								case 4:
									$I = "IV";
									$I1 = 4;
									$II = "I";
									$II2 = 1;
									$III = "II";
									$III3 = 2;
									$IV = "III";
									$IV4 = 3;
									break;
							
							default:
								# code...
								break;
						}
						
						?>
	
						<div class="column-2 campo-agregar-editar">
								<label for="grupo_disp" class="">Grupo Disp.</label>
								<select name="grupo_disp" id="grupo_disp" class="">
									<option value="<?php echo $I1 ?>"><?php echo $I ?></option>
									<option value="<?php echo $II2 ?>"><?php echo $II ?></option>
									<option value="<?php echo $III3 ?>"><?php echo $III ?></option>
									<option value="<?php echo $IV4 ?>"><?php echo $IV ?></option>
								</select>
						</div>
	
						<div class="column-3 campo-agregar-editar">
							<label for="manzana">Manzana</label>
							<input value="<?php echo $resultado_unico['manzana'] ?>" class="" type="text" name="manzana" id="manzana">
						</div>
	
						<div class="column-12 campo-agregar-editar">
							<label for="diagnostico">Diagnóstico</label>
							<input name="diagnostico" id="diagnostico" class="" value="<?php echo $resultado_unico['diagnostico'] ?>" type="text">
						</div>
	
						<input type="hidden" value="<?php echo $resultado_unico['id'] ?>" name="id">
						
						<div class="div-button column-2">
							<button class="btn btn-success" id="btn_editar">Editar</button>
						</div>
	
					</form>
					<?php endif ?>
				</div>
	</div>

			
		<div>
			<div class="contenedor">
				<div class="leyenda-tabla">
					<legend>Leyenda</legend>

					<div class="row">
						<p><span class="sano"></span> : Sano/a</p>
						<p><span class="enfermo"></span> : Enfermo/a</p>
					</div>

					<div class="row">
						
						<p><span class="riesgo"></span> : Riesgo</p>
						<p><span class="discapacitado"></span> : Discapacitado</p>
					</div>

				</div>

				<div class="contenedor-tabla">
				<table class="table" id="tabla">
					<thead>
						<tr>
							<!-- <th>No</th> -->
							<th>Nombre</th>
							<th>Sexo</th>
							<th>Grupo</th>
							<th>Dirección</th>
							<th>Edad</th>
							<th>Nivel</th>
							<th>Manzana</th>
							<th>Diagnóstico</th>
							<th>Total: <?php echo count($resultado) ?></th>
						</tr>
					</thead>
					<tbody>

					

						<?php 
						$conteo=1;
						foreach($resultado as $dato): ?>

						<?php 
							$num = null;
							switch ($dato['grupo_disp']) {
								case 1 :
									$num ="I";
									break;
								
								case 2:
									$num ="II";
									break;

								case 3:
									$num ="III";
									break;

									case 4:
									$num ="IV";
									break;
								
								default:
									# code...
									break;
							}
					
						?>

						<tr id="<?php echo $dato['id'] ?>" class="<?php echo $num ?>">
							<!-- <td class="negro"><?php echo $conteo; $conteo++; ?></td> -->
							<td><?php echo $dato['nombre_apellido'] ?></td>
							<td><?php echo $dato['sexo'] ?></td>
							<td ><?php echo $num ?></td>
							<td><?php echo $dato['direccion'] ?></td>
							<td><?php echo $dato['edad'] ?></td>
							<td><?php echo $dato['nivel_educacional'] ?></td>
							<td><?php echo $dato['manzana'] ?></td>
							<td><?php echo $dato['diagnostico'] ?></td>
							<td>
								<a href="index.php?id=<?php echo $dato['id'] ?>#editar" class="icono-editar-eliminar">
									<i class="icon-pencil "></i>
								</a>
							</td>
							<td>
								<button data-id="<?php echo $dato['id']; ?>" class="icono-editar-eliminar btn-borrar">
									<i class=" icon-trash-empty"></i>
								</button>
							</td>
						</tr>
						<?php endforeach ?>

					</tbody>
				</table>
					
				</div>
				
				
			</div>
		</div>

	<hr>

	<footer>
		<p>Version 1.1.2021</p>
		<p>Hecho por: Daniel Alberto Tamayo Trujillo</p>
	</footer>

	<script src="js/script.js"></script>

</body>
</html>

<?php

$gsent = null;
$pdo = null;

?>