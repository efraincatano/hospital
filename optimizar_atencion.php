<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optimizar Atención</title>
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
        <h3>Optimizar Atención</h3>
<?php

/*
Con el fin de optimizar la atención los pacientes se reorganizarán de forma tal que queden organizados de forma
óptima. Para esto los pacientes de mayor gravedad, en orden de urgencia, quedarán en el inicio, los niños y
ancianos a continuación por prioridad y orden de llegada y por último los jóvenes más sanos. Los pacientes que
se encuentren en la sala de espera serán ubicados según su orden original, siempre teniendo en cuenta su
prioridad y urgencia. Luego
*/

//Conexión a la base de datos.

$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";

$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if(mysqli_connect_errno()) {
    echo ("Error en la conexion con la base de datos");
}
//Mostrando en pantalla los pacientes de urgencia.
$ver_lista = urgencias($conexion, $DB_DATABASE);

if ($ver_lista->num_rows > 0) {
    echo ("<h5>Pacientes para ingresar a urgencias por orden de mayor riesgo</h5>");
    while($row = $ver_lista->fetch_assoc()) {
        echo "<p >Nombre: " . $row["nombre"]. " "."<br>" . "No de historia clinica: " . $row["noHistoriaClinica"]. " "."<br>" ." Riesgo: " . $row["riesgo"]. ""."<br>" ." Edad: " . $row["edad"]."  </p>" ."<br>";        
    }
  } else {
    echo "0 results";

}

//Obteniendo los pacientes con riesgo mayor a 4

function urgencias($conexion, $DB_DATABASE) {

    if(mysqli_connect_errno()) {
        echo ("Error en la conexion con la base de datos");
    }
    
    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE WHERE riesgo >4 ORDER BY riesgo DESC";

    $result = $conexion -> query($datos);
    return $result;
}
$ninnos = ninnos($conexion, $DB_DATABASE);

//Mostrando todos los niños con riesgo menor a 4
if ($ninnos->num_rows > 0) {
    echo ("<h5>Niños en sala de espera</h5>");
    while($row = $ninnos->fetch_assoc()) {
        if ($row["riesgo"] <= 4) {
            echo "<p >Nombre: " . $row["nombre"]. " "."<br>" . "No de historia clinica: " . $row["noHistoriaClinica"]. " "."<br>" ." Riesgo: " . $row["riesgo"]. ""."<br>" ." Edad: " . $row["edad"]."  </p>" ."<br>"; 
        }
             
    }
  } else {
    echo "0 results";

}
//Obteniendo todos los pacientes niños.
function ninnos($conexion, $DB_DATABASE) {

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE WHERE edad BETWEEN 1 AND 15";

    $result = $conexion -> query($datos);
    return $result;
}

$ancianos = ancianos($conexion, $DB_DATABASE);

//Mostrando todos los pacientes ancianos con riesgo menor a 4.
if ($ancianos->num_rows > 0) {
    echo ("<h5>Ancianos en sala de espera</h5>");
    while($row = $ancianos->fetch_assoc()) {
        if ($row["riesgo"] <= 4) {
            echo "<p >Nombre: " . $row["nombre"]. " "."<br>" . "No de historia clinica: " . $row["noHistoriaClinica"]. " "."<br>" ." Riesgo: " . $row["riesgo"]. ""."<br>" ." Edad: " . $row["edad"]."  </p>" ."<br>";   
        }     
    }
  } else {
    echo "0 results";

}

//Obteniendo todos los pacientes mayores a 41 años.
function ancianos($conexion, $DB_DATABASE) {

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE WHERE edad > 41";

    $result = $conexion -> query($datos);
    return $result;
}

$jovenes = jovenes($conexion, $DB_DATABASE);

//Mostrando todos los pacientes jóvenes con riesgo menor a 4
if ($jovenes->num_rows > 0) {
    echo ("<h5>Jovenes en sala de espera</h5>");
    while($row = $jovenes->fetch_assoc()) {
        if ($row["riesgo"] <= 4) {
            echo "<p >Nombre: " . $row["nombre"]. " "."<br>" . "No de historia clinica: " . $row["noHistoriaClinica"]. " "."<br>" ." Riesgo: " . $row["riesgo"]. ""."<br>" ." Edad: " . $row["edad"]."  </p>" ."<br>";   
        }     
    }
  } else {
    echo "0 results";

}

//Obteniendo todos los pacientes  jóvenes.
function jovenes($conexion, $DB_DATABASE) {

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE WHERE edad BETWEEN 16 AND 40";

    $result = $conexion -> query($datos);
    return $result;
}

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>