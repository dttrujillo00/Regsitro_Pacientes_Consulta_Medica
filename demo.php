<?php

include_once 'conexion.php';

if (empty($_POST['buscar_edad'])) {
	# code...
	$sql_leer = 'SELECT * FROM pacientes';
	$gsent = $pdo->prepare($sql_leer);
	$gsent->execute();
	$resultado = $gsent->fetchAll();
}else if(strlen($_POST['buscar_edad']) <= 2){
	$sql_leer = 'SELECT * FROM pacientes WHERE edad=?';
	$gsent = $pdo->prepare($sql_leer);
	$gsent->execute(array($_POST['buscar_edad']));
	$resultado = $gsent->fetchAll();
} else {
	$edades = explode("-", $_POST['buscar_edad']);

	$sql_leer = 'SELECT * FROM pacientes WHERE edad BETWEEN ? AND ?';
	$gsent = $pdo->prepare($sql_leer);
	$gsent->execute(array($edades[0],$edades[1]));
	$resultado = $gsent->fetchAll();
}

$buscado = array();

foreach ($_POST as $recibido) {
	
	if ($_POST['buscar_edad'] == $recibido or $_POST['input_id_edad'] == $recibido) {
		continue;
	}

	array_push($buscado, $recibido);

}

for ($i=0; $i < count($buscado); $i++) { 
	if (empty($buscado[$i])) {
		for($j=$i; $j<count($buscado)-1; $j++){
			$buscado[$j] = $buscado[$j+1];
			
		}

		for($j=$i; $j<count($buscado)-1; $j++){
			$buscado[$j] = $buscado[$j+1];
		
		}

		$i=$i-1;
	}
}

$buscado = array_unique($buscado);

$ids = array();

foreach ($resultado as $fila) {
	for ($i=0; $i < count($buscado)/2; $i+=2) { 
		$index = stristr($fila[$buscado[$i+1]], $buscado[$i]);
		if($index){
			array_push($ids,$fila[0]);
		}
	}
}

$ids_final = array();

for ($i=0; $i < count($ids)-1; $i++) { 
	
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






$sql_leer = null;
$pdo = null;

?>