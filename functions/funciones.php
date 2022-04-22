<?php

$today = date("d") . "-" . date("m") . "-" . date("Y");

function calcularEdad($nacimiento, $hoy)
{
    $valoresNacimiento = explode("-", $nacimiento);
    $valoresHoy = explode("-", $hoy);

    $diaNacimiento = $valoresNacimiento[0];
    $mesNacimiento = $valoresNacimiento[1];
    $anyoNacimiento = $valoresNacimiento[2];

    $diaHoy = $valoresHoy[0];
    $mesHoy = $valoresHoy[1];
    $anyoHoy = $valoresHoy[2];

    $edad = $anyoHoy - $anyoNacimiento;

    if ($mesNacimiento > $mesHoy) {
        return $edad - 1;
    } else if($mesNacimiento < $mesHoy){
        return $edad;
    }else if($diaNacimiento < $diaHoy){
        return $edad - 1;
    } else {
        return $edad;
    }
}

function necesitoActualizar($ultimaFecha, $hoy){
    $valoresUltimaFecha = explode("-", $ultimaFecha);
    $valoresHoy = explode("-", $hoy);

    $diaUltimaFecha = $valoresUltimaFecha[0];
    $mesUltimaFecha = $valoresUltimaFecha[1];
    $anyoUltimaFecha = $valoresUltimaFecha[2];

    $diaHoy = $valoresHoy[0];
    $mesHoy = $valoresHoy[1];
    $anyoHoy = $valoresHoy[2];

    $diffDia = $diaHoy - $diaUltimaFecha;
    $diffMes = $mesHoy - $mesUltimaFecha;
    $diffAnyo = $anyoHoy - $anyoUltimaFecha;

    if ($diffDia != 0 or $diffMes != 0 or $diffAnyo != 0) {
        return true;
    }
    
    return false;

}



?>