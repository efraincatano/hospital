<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mas pacientes antendidos</title>
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
        <h3>Consulta que mas pacientes ha atendido</h3>

<?php

//Programa que devuelve la consulta que más pacientes ha atendió hasta el momento. 

$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";

////Conexión a la base de datos.

$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if(mysqli_connect_errno()) {
    echo ("Error en la conexion con la base de datos");
}

//Respuesta que aparecerá en pantalla. 

$ver_lista = consulta_mas($conexion, $DB_DATABASE);

if ($ver_lista->num_rows > 0) {
    while($row = $ver_lista->fetch_assoc()) {

        echo "<p >ID: " . $row["ID"]. " "."<br>" . "Cantidad de pacientes atendidos: " . $row["cantPacientes"]. " "."<br>" ." Nombre del especialista: " . $row["nombreEspecialista"]. "<br>"."Tipo de consulta: " . $row["tipoConsulta"]. " "."<br>" . "Estado: " . $row["estado"]. " "."<br>" . "</p>";
        
    }
  } else {
    echo "0 results";

}

//Obteniendo la consulta con numero mas alto de pacientes atendidos.  

function consulta_mas($conexion, $DB_DATABASE) {

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM CONSULTA WHERE cantPacientes = (SELECT MAX(cantPacientes) FROM CONSULTA) ORDER BY cantPacientes";

    $result = $conexion -> query($datos);
    return $result;
}

?>


    
</body>
</html>
