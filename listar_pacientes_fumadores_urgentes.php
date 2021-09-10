<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes fumadores</title>
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
        <h3>Pacientes fumadores que necesitan ser atendidos con urgencia</h3>

<?php

//Programa para mostrar todos los pacientes fumadores y con riesgo mayor a 4  
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

$datos = "SELECT * FROM PACIENTE";

$result = $conexion -> query($datos);

//Algoritmo de condición que determina los pacientes que aparecerán en la pantalla.  

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        if ($row["fumador"] & $row["riesgo"] >= 4) {
            
            echo "<p >Nombre: " . $row["nombre"]. " "."<br>" . "No de historia clinica: " . $row["noHistoriaClinica"]. " "."<br>" ." Riesgo: " . $row["riesgo"]. "</p><br>";

        }
    }

  }else {
      echo ("Error al cargar los datos");
  }

?>


    
</body>
</html>