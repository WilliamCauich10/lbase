<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
require_once "../../modelo/padrones.php";
require_once "../../modelo/contactos.php";
$tipo = isset($_POST["OPT"]) ? $_POST["OPT"] : "";
$tipo();
function CrearEnlaces(){
    // echo "holis desde acciones de controlador";
}
function CrearPadron(){
    
}
function CrearPadronDetalleUp(){
    
}
function CrearPadronDetalleNW(){
    
}
function borrarUserDetalle(){
    $idUser = isset($_POST["id_User"]) ? $_POST["id_User"] : "";
    $id_cambio = isset($_POST["id_cambio"]) ? $_POST["id_cambio"] : "";
    $idPadron = isset($_POST["idPadron"]) ? $_POST["idPadron"] : ""; 
    $NombrePadron = isset($_POST["NombrePadron"]) ? $_POST["NombrePadron"] : "";   
    // id_cambio == 0 se eliminara solo de detalle padron idPadron
    // si es otro numero se elimninara tanto del deltalle padron como de la tabla contactos
    $User_BorrarDetalle = Contactos::BorrarDetalle($idPadron,$idUser);
      echo $User_BorrarDetalle ?
        "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>Usuario eliminado con exito!  \" data-status=\"success\" data-pos=\"top-center\">Success</button>" : 
        "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>No se pudo eliminar el usuario \" data-status=\"danger\" data-pos=\"top-center\">Danger</button>"; 
    if ($id_cambio == '0') { 
    }else{
        $User_Borrar = Contactos::Borrar($idUser);
          echo $User_Borrar ? 
            "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>Usuario eliminado con exito!  \" data-status=\"success\" data-pos=\"top-center\">Success</button>" : 
            "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>No se pudo eliminar el usuario \" data-status=\"danger\" data-pos=\"top-center\">Danger</button>"; 
    }
    ?> 
    <script>
        var idpadron = "<?php echo $idPadron; ?>"
        var nombrepadron ="<?php echo $NombrePadron; ?>"
        jQuery(function(){
            jQuery('#Respuesta').click();
        });
        // PrincilaEnlace();
        PrincipalDetalles(nombrepadron,idpadron);
    </script>
        <?php 
}

?>