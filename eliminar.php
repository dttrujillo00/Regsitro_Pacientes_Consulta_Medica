<?php

include_once 'conexion.php';

$id = $_GET['id'];

$sql_eliminar = 'DELETE FROM pacientes WHERE id=?';
$sentencia_eliminar = $pdo->prepare($sql_eliminar);
$sentencia_eliminar->execute(array($id));

$sentencia_eliminar = null;
$pdo = null;

?>