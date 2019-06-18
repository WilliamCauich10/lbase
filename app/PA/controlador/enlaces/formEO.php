<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
// crear usuario padron detalle
function Crear(){
    
}
function UpdateContactosPadronDetalles(){
   
}
?>