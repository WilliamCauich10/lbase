<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
// echo $tipo;
function Editar_Contactos_Padrones(){
    $idPadron = isset($_POST["Id_U"]) ? $_POST["Id_U"] : "";
    echo "hola ".$idPadron;
?>
<?php 
}
// funcion Busqueda de contactos para padrones detalles
function Busq_Crear_Contactos(){

}
function PadronNW(){
    $idPadron = isset($_POST["idPadron"]) ? $_POST["idPadron"] : "";

}
?>
