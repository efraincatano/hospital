<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Pacientes Mayor Riesgo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <link type="text/css" rel="stylesheet" href="index.css">
</head>
<body>
    <div id="titulo">
    <div class="p-3 mb-2 bg-primary text-white">Sistema Control del Consultorio</div>
    </div>
    <div id="espacio"></div>
        <a id="volver" href="index.html">Volver al panel de control</a>
        <h3>Lista de pacientes con mayor riesgo</h3>
  

<?php

/*
Este programa consiste en dado un numero de historia clínica mostrar todos los pacientes con mayor 
riesgo que el paciente al que pertenece el número de historia clínica.  
*/

//Conexión a la base de datos.
$noHistoriaClinica = $_GET["noHistoriaClinica"];

$DB_HOST = "localhost";
$DB_DATABASE = "hospital";
$DB_USER = "root";
$DB_PASSWORD = "";


$conexion = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_DATABASE);

if(mysqli_connect_errno()) {
  echo ("Error en la conexion con la base de datos");
}


$ver_lista = Listar_Pacientes_Mayor_Riesgo($conexion, $DB_DATABASE);

//Algoritmo de condición que determina los pacientes que aparecerán en la pantalla.  

if ($ver_lista->num_rows > 0) {
    $riesgo = obtener_riesgo($noHistoriaClinica, $conexion, $DB_DATABASE);

    while($row = $ver_lista->fetch_assoc()) {

        if(intval($riesgo)<intval($row["riesgo"])) {
            echo "<p >Nombre: " . $row["nombre"]. " - No de historia clinica: " . $row["noHistoriaClinica"]. " - Riesgo: " . $row["riesgo"]. "</p><br>";
        } 

    }
  } else {
    echo "0 results";
  }
//Obteniendo lista de pacientes.  
function Listar_Pacientes_Mayor_Riesgo($conexion, $DB_DATABASE) {

    mysqli_select_db($conexion, $DB_DATABASE) or die ("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");

    $datos = "SELECT * FROM PACIENTE";

    $result = $conexion -> query($datos);
    return $result;
}

//Obteniendo el riesgo de todos los pacientes  
function obtener_riesgo($noHistoriaClinica, $conexion, $DB_DATABASE) {
    $riesgo = 0;
    $ver = Listar_Pacientes_Mayor_Riesgo($conexion, $DB_DATABASE);
    if ($ver->num_rows > 0) {
    
        while($row = $ver->fetch_assoc()) {
            if ($noHistoriaClinica==$row["noHistoriaClinica"]) {
                $riesgo = $row["riesgo"];
            }
        }
      } else {
        echo "0 results";
      }
    return $riesgo;
}
?>
          <footer style="margin-top : 320px">
            <div class="p-3 mb-2 bg-primary text-white">Powered by <a href="https://www.inexoos.com/en/home-english/">Inexoos</a> &copy; Todos los derechos revervados</div>
          </footer>

</body>
</html>
