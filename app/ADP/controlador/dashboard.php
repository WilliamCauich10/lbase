<?php 
session_start();
require_once "../modelo/dashboard.php";

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
 
function Dashboard1(){
    $Id_Enlace = $_SESSION['Id_EnlaceOP'];
    $datos =Dashboard::Dashboard1($Id_Enlace);    
    require_once("../vista/Enlaces/datos.php");
}
function Dashboard2(){
    $Id_Proyecto = $_SESSION['id_proyecto'];
    $datos1 =Dashboard::Dashboard2($Id_Proyecto); 
    echo json_encode($datos1);
}
function prueba(){
    $datos =Dashboard::lienaRegistro(); 
    echo json_encode($datos);
}
// echo $datos[1]["Nombre"];
// for ($i = 0; $i < count($datos); $i++) {
//     echo $datos[$i]["Nombre"];;
// }

?>