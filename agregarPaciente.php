<?php

include_once 'conexion.php';
include_once 'functions/funciones.php';

$nombre_apellido = $_POST['nombre_apellido'];
	$sexo = $_POST['sexo'];
	$grupo_disp = $_POST['grupo_disp'];
	$direccion = $_POST['direccion'];
	$edad = calcularEdad($_POST['fecha_nacimiento'], $today);
	$fecha_nacimiento = $_POST['fecha_nacimiento'] ;
	$nivel_educacional = $_POST['nivel_educacional'];
	$manzana = $_POST['manzana'];	
	if(!strcmp($_POST['diagnostico'],'')){
		$diagnostico = "Sano";
	}else{
		$diagnostico = $_POST['diagnostico'];
	}

	$sql_agregar = 'INSERT INTO pacientes (nombre_apellido, sexo, grupo_disp, direccion, fecha_nacimiento, nivel_educacional, manzana, diagnostico, edad) VALUES(?,?,?,?,?,?,?,?,?)';
	$sentencia_agregar = $pdo->prepare($sql_agregar);
    $sentencia_agregar->execute(array($nombre_apellido, $sexo, $grupo_disp, $direccion, $fecha_nacimiento, $nivel_educacional, $manzana, $diagnostico, $edad));

    $sql_sacar_id = 'SELECT MAX(id) FROM pacientes';
    $sentencia_sacar_id = $pdo->prepare($sql_sacar_id);
    $sentencia_sacar_id->execute();
    $id_ultimo = $sentencia_sacar_id->fetch();
    
    $respuesta = array(
        'respuesta' => 'correcto',
        'datos' => array(
            'nombre' => $nombre_apellido,
            'sexo' => $sexo,
            'grupo_disp' => $grupo_disp,
            'direccion' => $direccion,
            'nivel_educacional' => $nivel_educacional,
            'manzana' => $manzana,
            'diagnostico' => $diagnostico,
            'edad' => $edad,
            'id_insertado' => $id_ultimo[0]
        )
    );

    

	$sentencia_agregar = null;
	$pdo = null;
    
    echo json_encode($respuesta);


?>