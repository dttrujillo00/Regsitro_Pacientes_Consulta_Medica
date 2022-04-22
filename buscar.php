<?php

include_once 'conexion.php';

$flag_edad = null;

//HACIENDO CONSULTA DE ACUERDO AL CAMPO EDAD

/*********BUSQUEDA DE UNA SOLA EDAD*********/	
if(strlen($_POST['buscar_edad']) <= 2 and strlen($_POST['buscar_edad']) >= 1){

	$sql_leer = 'SELECT * FROM pacientes WHERE edad=? ORDER BY edad';
	$gsent = $pdo->prepare($sql_leer);
	$gsent->execute(array($_POST['buscar_edad']));
	$resultado = $gsent->fetchAll();

} else if(strlen($_POST['buscar_edad']) >= 3){  /********BUSQUEDA ENTRE 2 EDADES********/
	$edades = explode("-", $_POST['buscar_edad']);

	$sql_leer = 'SELECT * FROM pacientes WHERE edad BETWEEN ? AND ? ORDER BY edad';
	$gsent = $pdo->prepare($sql_leer);
	$gsent->execute(array($edades[0],$edades[1]));
	$resultado = $gsent->fetchAll();
} else {   /*********NO SE UTILIZÓ EL CAMPO EDAD*********/
	$sql_leer = 'SELECT * FROM pacientes ORDER BY edad';
	$gsent = $pdo->prepare($sql_leer);
	$gsent->execute();
	$resultado = $gsent->fetchAll();
}
//echo "Resultado de consulta<br>";
//var_dump($resultado);

/**GUARDANDO TODOS LOS CAMPOS DE BUSQUEDA */
$buscar_nombre = $_POST['buscar_nombre'];
$buscar_sexo = $_POST['buscar_sexo'];
$buscar_grupo = $_POST['buscar_grupo'];
$buscar_direccion = $_POST['buscar_direccion'];
$buscar_n_educacional = $_POST['buscar_n_educacional'];
$buscar_manzana = $_POST['buscar_manzana'];
$buscar_diagnostico = $_POST['buscar_diagnostico'];

//CREANDO ARRAY PARA GUARDAR LOS CAMPOS
$buscado = array();

/** COMPROBANDO QUE CAMPOS SE ESTAN BUSCANDO **/
if ($_POST['buscar_nombre'] != '') {
    array_push($buscado, $_POST['buscar_nombre'], '1');
}

if ($_POST['buscar_sexo'] != '') {
     array_push($buscado, $_POST['buscar_sexo'], '2');
}

if ($_POST['buscar_grupo'] != '') {
    array_push($buscado, $_POST['buscar_grupo'], '3');
}

if ($_POST['buscar_direccion'] != '') {
    array_push($buscado, $_POST['buscar_direccion'], '4');
}

if ($_POST['buscar_n_educacional'] != '') {
    array_push($buscado, $_POST['buscar_n_educacional'], '6');
}

if ($_POST['buscar_manzana'] != '') {
    array_push($buscado, $_POST['buscar_manzana'], '7');
}

if ($_POST['buscar_diagnostico'] != '') {
    array_push($buscado, $_POST['buscar_diagnostico'], '8');
}

if ($_POST['buscar_edad'] != '') {
    $flag_edad = true;
}

// var_dump($buscado);

/**COMPROBANDO SI SOLO SE BUSCA EN EL CAMPO EDAD */
if ($flag_edad == true and empty($buscado)) {
    $ids_final = array();

	/**GUARDAR A TODOS LOS DEVUELTO POR LA CONSULTA EN EL ARREGLO DE $ids_final */
    foreach ($resultado as $fila) {
        array_push($ids_final, $fila['id']);
    }
    
} else if(empty($buscado)){
    		header('location:index.php');
		} else {

			//GUARDANDO LOS ID DE LAS FILAS QUE COINCIDEN CON LOS RESULTADOS DE BUSQUEDAS   
			$ids = array();

			foreach ($resultado as $fila) {
				/**REALIZO BUSQUEDA Y GUARDO EL ID DEL QUE COINCIDA EN $ids
				 * BUSCA EN UN MISMO PACIENTE LOS CAMPOS QUE LE COINCIDEN
				 */
				for ($i=0; $i <= count($buscado)/2; $i+=2) { 
					$index = stristr($fila[$buscado[$i+1]], $buscado[$i]);
					if($index){
						array_push($ids,$fila[0]);
					}
				}
			}
			// var_dump($ids);

			$ids_final = array();
			/**BUSCO CUALES ID SE REPITEN LA MISMA CANTIDAD DE VECES QUE LOS CAMPOS BUSCADOS
			 * QUE POR LO TANTO SON LOS RESULTADOS FINALES
			 * Y LOS GUARDO EN $ids_final
			 */
			for ($i=0; $i < count($ids); $i++) { 
				
				$conteo = 1;
				
				for($j=$i+1; $j < count($ids); $j++){
					if($ids[$i] == $ids[$j]){
						$conteo++;
					}
				}

				if($conteo == count($buscado)/2){
					array_push($ids_final,$ids[$i]);
				}
				
			}
}

//HACIENDO UNA ULTIMA CONSULTA DE LOS IDS RESULTANTES DE LA BUSQUEDA

	$resul_busqueda = array();
	for($j=0;$j<count($ids_final);$j++){
		$sql_leer_resultado = 'SELECT * FROM pacientes WHERE id=?';
		$sentencia_leer_resultado = $pdo->prepare($sql_leer_resultado);
		$sentencia_leer_resultado->execute(array($ids_final[$j]));
		array_push($resul_busqueda, $sentencia_leer_resultado->fetch());
	}




?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/fontello.css">
    <title>Resultados</title>
</head>
<body class="contenedor">
    <header class="imagen-fondo header-buscar-pag">
		<h3>RESULTADOS DE LA BÚSQUEDA: <?php echo count($resul_busqueda) ?> COINCIDENCIAS</h3>
	</header>

    <div>
		<table class="table">
			<thead>
            <tr>
                <th>No</th>
				<th>Nombre</th>
				<th>Sexo</th>
				<th>Grupo</th>
				<th>Dirección</th>
				<th>Edad</th>
				<th>Nivel</th>
				<th>Manzana</th>
				<th>Diagnóstico</th>
			</tr>
			</thead>
			<tbody>

            <?php 
            $conteo=1;
            foreach($resul_busqueda as $r_busqueda): ?>
            <?php 
							$num = null;
							switch ($r_busqueda['grupo_disp']) {
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

                        <tr id="<?php echo $r_busqueda['id'] ?>" class="<?php echo $num ?>">
                            <td class="negro"><?php echo $conteo; $conteo++; ?></td>
							<td><?php echo $r_busqueda['nombre_apellido'] ?></td>
							<td><?php echo $r_busqueda['sexo'] ?></td>
							<td ><?php echo $num ?></td>
							<td><?php echo $r_busqueda['direccion'] ?></td>
							<td><?php echo $r_busqueda['edad'] ?></td>
							<td><?php echo $r_busqueda['nivel_educacional'] ?></td>
							<td><?php echo $r_busqueda['manzana'] ?></td>
							<td><?php echo $r_busqueda['diagnostico'] ?></td>
							<td><a class="nav-link" href="index.php?id=<?php echo $r_busqueda['id'] ?>#editar"><i style="font-size: 1.3rem; color: black" class="icon-pencil"></i></a></td>
							<td><a class="nav-link" href="eliminar.php?id=<?php echo $r_busqueda['id'] ?>"><i style="font-size: 1.3rem; color: black" class="icon-trash-empty"></i></a></td>
						</tr>
			<?php endforeach ?>

			</tbody>
		</table>
	</div>

	<footer>
		<p>Version 1.1.2021</p>
		<p>Hecho por: Daniel Tamayo Trujillo</p>
	</footer>

</body>
</html>

<?php

$sentencia_leer = null;
$sentencia_leer_resultado = null;
$pdo = null;

?>