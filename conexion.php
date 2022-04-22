<?php

//VARIABLES PARA CREAR LA CONEXION CON LA BASE DE DATOS
$link = 'mysql:host=localhost;dbname=consulta_medica';
$usuario = 'root';
$pass = '';

try{
	$pdo = new PDO($link, $usuario, $pass);

}catch(PDOException $e){
	print "ERROR! " . $e->getMessage() . "<br>";
	die();
}