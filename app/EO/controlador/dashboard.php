<?php 
session_start();
require_once "../modelo/dashboard.php";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
 
function Dashboard1(){
    $Id_enlace = $_SESSION['Id_EnlaceOP'];
    $datos =Dashboard::Dashboard1($Id_enlace);    
    echo json_encode($datos);
    // require_once("../vista/Enlaces/datos.php");
}
function Dashboard2(){
    $Id_enlace = $_SESSION['Id_EnlaceOP'];
    $datos1 =Dashboard::Dashboard2($Id_enlace); 
    echo json_encode($datos1);
}
function prueba(){
    $datos =Dashboard::lienaRegistro(); 
    echo json_encode($datos);
}
function DispersionDashboard(){
    $Segmento = isset($_POST['segmento']) ? $_POST['segmento'] : "";
    $datos =Dashboard::DispersionDashboard($Segmento); 
    echo json_encode($datos);
}
function graficaSindicatos(){
    $distrito = isset($_POST['distrito']) ? $_POST['distrito'] : "";
    $stmt = Dashboard::GetGraficaSindicatos($distrito);
    echo json_encode($stmt);
}
function obtenerTablaGraficaSindicatos(){
    $distrito = isset($_POST['distrito']) ? $_POST['distrito'] : "";
    $stmt = Dashboard::GetTablaGraficaSindicatos($distrito);
    echo json_encode($stmt);
}
function obtenerTablaGraficaMunicipios(){
    $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : "";
    $stmt = Dashboard::GetTablaGraficaMunicipios($municipio);
    echo json_encode($stmt);
}
function graficaMunicipios(){
    $municipio = isset($_POST['municipio']) ? $_POST['municipio'] : "";
    $stmt = Dashboard::GetGraficaMunicipios($municipio);
    echo json_encode($stmt);
}
// echo $datos[1]["Nombre"];
// for ($i = 0; $i < count($datos); $i++) {
//     echo $datos[$i]["Nombre"];;
// }

?>