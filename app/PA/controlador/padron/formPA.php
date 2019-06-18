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
function CrearUserPadron(){
    $id_enlace = $_SESSION['Id_EnlaceOP'];
   
}
function UpdateUserPadron(){
   
}
?>