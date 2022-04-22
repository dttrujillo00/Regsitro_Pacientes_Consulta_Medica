<?php

include_once 'conexion.php';
include_once 'functions/funciones.php';

$id_editar = $_GET['id'];
$nombre_editar = $_GET['nombre_apellido'];
$sexo_editar = $_GET['sexo'];
$grupo_editar = $_GET['grupo_disp'];
$direccion_editar = $_GET['direccion'];
$edad_editar = calcularEdad($_GET['fecha_nacimiento'], $today);
$fecha_editar = $_GET['fecha_nacimiento'];
$nivel_editar = $_GET['nivel_educacional'];
$manzana_editar = $_GET['manzana'];
$diagnostico_editar = $_GET['diagnostico'];




$sql_editar = 'UPDATE pacientes SET nombre_apellido=?, sexo=?, grupo_disp=?, direccion=?, fecha_nacimiento=?, nivel_educacional=?, manzana=?, diagnostico=?, edad=? WHERE id=?';
$sentencia_editar = $pdo->prepare($sql_editar);
$sentencia_editar->execute(array($nombre_editar, $sexo_editar, $grupo_editar, $direccion_editar, $fecha_editar, $nivel_editar, $manzana_editar, $diagnostico_editar, $edad_editar, $id_editar));

$sentencia_editar = null;
$pdo = null;
header('location:index.php#' . $id_editar);

?>