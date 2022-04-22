<?php

include_once 'conexion.php';
include_once 'functions/funciones.php';

// $today = date("d") . "-" . date("m") . "-" . date("Y");

$query = 'SELECT * FROM fechaActualizacionEdad';
$stmt = $pdo->prepare($query);
$stmt->execute();
$resultado = $stmt->fetch();


if(necesitoActualizar($resultado[0], $today)){
     echo 'Necesitas actualizar<br>';

    $query = 'UPDATE fechaActualizacionEdad SET ultimaActualizacion=?';
    $stmt = $pdo->prepare($query);
    $stmt->execute(array($today));

    $sql_leer = 'SELECT * FROM pacientes';
    $gsent = $pdo->prepare($sql_leer);
    $gsent->execute();
    $resultado = $gsent->fetchAll();

    foreach ($resultado as $paciente) {
        echo '<br><br>';
        echo $paciente['fecha_nacimiento'] . '<br>';
        echo calcularEdad($paciente['fecha_nacimiento'], $today);
        $edad_actual = calcularEdad($paciente['fecha_nacimiento'], $today);
        $id_actual = $paciente['id'];

        $sql_editar = 'UPDATE pacientes SET edad=? WHERE id=?';
        $sentencia_editar = $pdo->prepare($sql_editar);
        $sentencia_editar->execute(array($edad_actual, $id_actual));

        echo $sentencia_editar->rowCount() . 'filas actualizadas<br>';

        echo 'Edad revisada<br>';

    }
    
        // echo 'Actualizacion Guardada';
    
} else{
     echo 'No hace falta actualizar';

 }



?>