<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paciente mas anciano</title>
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
        <h3>Paciente mas anciano</h3>

<?php

//Programa para obtener el paciente mas anciano en la sala de espera.

//Conexión a la base de datos.
$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";


$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

$ver_lista = mas_anciano($conexion, $DB_DATABASE);

//Resultado que se muestra en pantalla.
if ($ver_lista->num_rows > 0) {
    while($row = $ver_lista->fetch_assoc()) {

        echo "<p >Nombre: " . $row["nombre"]. " "."<br>" . "No de historia clinica: " . $row["noHistoriaClinica"]. " "."<br>" ." Riesgo: " . $row["riesgo"]. ""."<br>" ." Edad: " . $row["edad"]."  </p>" ."<br>";
        
    }
  } else {
    echo "0 results";

}

//Obteniendo el paciente más anciano.
function mas_anciano($conexion, $DB_DATABASE) {

    if(mysqli_connect_errno()) {
        echo ("Error en la conexion con la base de datos");
    }
    
    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE WHERE edad = (SELECT MAX(edad) FROM PACIENTE) ORDER BY edad";

    $result = $conexion -> query($datos);
    return $result;
}

?>


    
</body>
</html>

