<?php 
session_start();
require_once "../../modelo/padrones.php";
require_once "../../modelo/contactos.php";
$tipo = isset($_POST["OPT"]) ? $_POST["OPT"] : "";
$tipo();
function CrearEnlaces(){
    // echo "holis desde acciones de controlador";
}
function BorrarPadron(){
    $idPadron = isset($_POST["idPadron"]) ? $_POST["idPadron"] : "";  
    $idResponasable = isset($_POST["idResponasable"]) ? $_POST["idResponasable"] : "";  
    $id_cambio = isset($_POST["id_cambio"]) ? $_POST["id_cambio"] : "";  
    // 
    $Results = $GLOBALS['pdo']->prepare("SELECT * FROM detalle_padron AS T1 WHERE T1.Id_Padron = '$idPadron' ");
    $execute = $Results -> execute();
    if ($Results -> rowCount() > 0 ) {
        echo "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>El padron contiene datos\" data-status=\"danger\" data-pos=\"top-center\">Success</button>";
    }else{
        $PA_borrar = Padrones::Borrar($idPadron);
        echo $PA_borrar ? "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a> Eliminado con exito\" data-status=\"success\" data-pos=\"top-center\">Success</button>" :"<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>Error al eliminar padron\" data-status=\"danger\" data-pos=\"top-center\">Success</button>"; 
        if ($id_cambio =='0') {
            // echo "borrar usuario";
        }else{
            $User_Borrar = Contactos::Borrar($idResponasable);

        }
     }
     ?> 
    <script>
        jQuery(function(){
            jQuery('#Respuesta').click();
        });
        PrincilaEnlace();
    </script>
     <?php 
}

?>