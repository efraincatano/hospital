<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antender paciente</title>
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
        <h3>Antender paciente</h3>

<?php

/*
Este programa buscara al paciente con mas riesgo y una consulta de urgencia desocupada para entender 
al paciente, el estado de la consulta pasara a ocupada.
*/

////Conexión a la base de datos.
$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";


$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if(mysqli_connect_errno()) {
    echo ("Error en la conexion con la base de datos");
}

//Función que busca una consulta disponible y cambia el estado a ocupada de la misma.
function consultas_disponibles($conexion, $DB_DATABASE){

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM CONSULTA";

    $result = $conexion -> query($datos);

    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc() ) {
            if ($row["estado"] == "Desocupada" & $row["tipoConsulta"] == "urgencia") {       
                $consulta_mensaje = $conexion -> query($datos);
                $consulta = mysqli_fetch_array ($consulta_mensaje);
                $consulta_id = intval($consulta["ID"]);
                $actualizar_consulta = "UPDATE CONSULTA SET estado = 'Ocupada' WHERE ID = $consulta_id";  
                $actualizacion = $conexion -> query($actualizar_consulta); 

                echo ("<h5>Consulta disponible:</h5>"); 
                echo ("ID : ".$consulta["ID"]."<br>");
                echo ("Nombre del especialista : ".$consulta["nombreEspecialista"]."<br>");
                echo ("Tipo de consulta : ".$consulta["tipoConsulta"]."<br>");
                
            }
        }
        
      }
}

//Llamada a la función de consulta disponible.
consultas_disponibles($conexion, $DB_DATABASE); 

//Función que busca al paciente con riesgo más alto.
function antender_paciente($conexion, $DB_DATABASE) {

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE WHERE riesgo = (SELECT MAX(riesgo) FROM PACIENTE) ORDER BY riesgo";

    $result = $conexion -> query($datos);
    $paciente = mysqli_fetch_array ($result);
    return $paciente;
}
//Llamada  al función atender paciente y mostrándolo en la pantalla.
$ver_lista = antender_paciente($conexion, $DB_DATABASE);

echo ("<h5>Persona con mas alto riesgo en sala de espera</h5>");
echo ("Nombre: ".$ver_lista["nombre"]."<br>");
echo ("Edad: ".$ver_lista["edad"]."<br>");
echo ("No historia clinica: ".$ver_lista["noHistoriaClinica"]."<br>");
echo ("Riesgo: ".$ver_lista["riesgo"]."<br>");

$edad = intval($ver_lista["edad"]);
$riesgo = intval($ver_lista["riesgo"]);

function tipo_pac($edad){
    if($edad >= 1 & $edad >=15){
        $tipo = "ninno";
    }
    if($edad >= 16 & $edad >=40){
        $tipo = "joven";
    }
    if($edad >= 41){
        $tipo = "anciano";
    }

    return $tipo;
    
}

$tipo_paciente = tipo_pac($edad);

?>
   
</body>
</html>
