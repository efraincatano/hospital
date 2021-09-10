<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liberar consultas</title>
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

//Esta función cambiara todas las consultas con estado “Ocupada” a “Desocupadas”.  

$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";

//Conexión a la base de datos.

$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if(mysqli_connect_errno()) {
    echo ("Error en la conexion con la base de datos");
}

mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
mysqli_set_charset($conexion, "utf8");

//Actualizando las consultas ocupadas.  

$actualizar_consultas = "UPDATE CONSULTA SET estado = 'Desocupada' WHERE estado='Ocupada'";

$result = $conexion -> query($actualizar_consultas);

if ($result) {
    echo ("<h3>Todas las consultas ocupadas han sido liberadas</h3>");

}else {
    echo ("Ha habido un problema en la actualización de los datos");
}

?>


    
</body>
</html>