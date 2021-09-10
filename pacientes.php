<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link type="text/css" rel="stylesheet" href="index.css">
</head>
<body>
<div id="titulo">
    <div class="p-3 mb-2 bg-primary text-white">Sistema Control del Consultorio</div>
    </div>
    <div id="body">
        <div id="espacio"></div>
        <a id="volver" href="index.html">Volver al panel de control</a><br>
        <hr>
<?php

//Recibiendo los datos del formulario para ingresar pacientes HTML.

$nombre = $_POST["nombre"];
$edad = $_POST["edad"];
$noHistoriaClinica = $_POST["noHistoriaClinica"];
$edad = intval($edad);
$prioridad = 0;
$riesgo = 0;

//Los campos no requeridos serán tendrán el valor 0 si están vacíos.

if (isset($_POST["fumador"])) {
    $fumador = 1;
}
    else {
        $fumador = 0;
    }

if (isset($_POST["annosfumador"])) {
    $annosfumador = $_POST["annosfumador"];
    $annosfumador = intval($annosfumador);
}
    else{
        $annosfumador = 0;
    }

if (isset($_POST["dieta"])) {
    $dieta = 1;
}
    else{
        $dieta = 0;
    }

if (isset($_POST["relacionPesoAltura"])) {
    $relacionPesoAltura = $_POST["relacionPesoAltura"];
    $relacionPesoAltura =  intval($relacionPesoAltura);
}
   else {
       $relacionPesoAltura = 0;
   }

/*
El programa determina el riesgo y la prioridad dependiendo de la edad y otros datos como si es 
fumador, tiene dieta y la relación peso altura. 
*/

$tipo_paciente = 0;

if ($edad >= 1 & $edad <= 15) {
    $tipo_paciente = "ninno";
}

if ($edad >= 16 & $edad <= 40) {
    $tipo_paciente = "joven";
}

if ($edad >= 41) {
    $tipo_paciente = "anciano";
}
        
switch($tipo_paciente){
    case "ninno":
        if ($edad >=1 & $edad <=5) {
            $prioridad = $relacionPesoAltura + 3;
        }
        if ($edad >=6 & $edad <=12) {
            $prioridad = $relacionPesoAltura + 2;
        }
        if ($edad >=13 & $edad <=15) {
            $prioridad = $relacionPesoAltura + 1;
        }
        $riesgo = ($edad * $prioridad) / 100;

    case "joven":
        if($fumador){
            $prioridad = $annosfumador / 4 + 2;
        }
           else{
               $prioridad = 2;
           }
        $riesgo = ($edad * $prioridad) / 100;  

    case "anciano":
        if($dieta = 1 & $edad >=60 & $edad >= 100){
            $prioridad = $edad/20 + 4;
        }
            else {
                $prioridad = $edad/30 + 3;
            }
        $riesgo = ($edad * $prioridad)/100 + 5.3;

}

$prioridad = intval($prioridad);
$riesgo = intval($riesgo);

//Conexión a la base de datos.

$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";

$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);


if(mysqli_connect_errno()) {
    echo ("Error en la conexion con la base de datos");
}

mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
mysqli_set_charset($conexion, "utf8");

//Insertando datos a la base de datos. 

$consulta_pacientes = "INSERT INTO PACIENTE (nombre, edad, noHistoriaClinica, fumador, annosfumador, dieta, relacionPesoAltura, prioridad, riesgo)
VALUES ('".$nombre ."', '".$edad ."', '".$noHistoriaClinica ."', '".$fumador ."', '".$annosfumador ."', '".$dieta ."','".$relacionPesoAltura ."','".$prioridad ."','".$riesgo ."')";

$result = mysqli_query($conexion, $consulta_pacientes);

//Respuesta que aparecerá en pantalla. 

if($result == true){
    echo ("Paciente agregado con exito" . "<br>");
    echo ("Nombre: ". $nombre . "<br>");
    echo ("Edad: ". $edad . "<br>");
    echo ("Numero de Historia Clinica: ". $noHistoriaClinica . "<br>");
    echo ("Riesgo: ". $riesgo . "<br>");
}else{
    echo ("Error al ingrasar el paciente");
}


?>


</body>
</html>
