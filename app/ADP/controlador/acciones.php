<?php 
session_start();
require_once "../modelo/enlace.php";
// require_once "../../EO/modelo/contactos.php";
$tipo = isset($_POST["OPT"]) ? $_POST["OPT"] : "";
$tipo();
function CrearEnlaceUpUser(){
    $Id_Proyecto = $_SESSION['id_proyecto'];
    $NombreEnlace = isset($_POST["NombreEnlace"]) ? $_POST["NombreEnlace"] : "";
    $idUser = isset($_POST["idUser"]) ? $_POST["idUser"] : "";
    // Update usuario
    $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
    $APP = isset($_POST["APP"]) ? $_POST["APP"] : "";
    $APM = isset($_POST["APM"]) ? $_POST["APM"] : "";
    $Direccion = isset($_POST["Direccion"]) ? $_POST["Direccion"] : "";
    $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";
    $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
    $Contraseña = isset($_POST["Contraseña"]) ? $_POST["Contraseña"] : "";
    $Seccion = isset($_POST["Seccion"]) ? $_POST["Seccion"] : "";
    // agregar usuario
    $User_New = Enlace::CrearUser(3,$Nombre,$APP,$APM,$Direccion,$Telefono,$Correo,$Contraseña,$idUser, $Seccion,0, $Id_Proyecto);
    // id usuario registrado
    $Results = $GLOBALS['pdo']->prepare("SELECT @@identity AS Id_Contacto");
    $execute = $Results -> execute();
    while( $row = $Results -> fetch()){
        $id_User = trim($row[0]);
    } 
    $Enlace_New = Enlace::CrearEnlace($Id_Proyecto,$id_User,3,$NombreEnlace);
     echo $Enlace_New ?       
     "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>No se pudo registrar el enlace  \" data-status=\"danger\" data-pos=\"top-center\">Danger</button>" : 
    "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>Enlace registrado con exito!\" data-status=\"success\" data-pos=\"top-center\">Success</button>"; 
    // Id enlace
    $Results2 = $GLOBALS['pdo']->prepare("SELECT @@identity AS Id_Enlace");
    $execute2 = $Results2 -> execute();
    while( $row2 = $Results2 -> fetch()){
        $Id_enlace = trim($row2[0]);
    }    
        $Enlace_New2 = Enlace::UpdateEnlace($id_User,$Id_enlace);
    // 
    ?> 
    <script>
      
        jQuery(function(){
            jQuery('#Respuesta').click();
        });
        principalEnlacesOP();
    </script>
     <?php 
}
function BorrarEnlace(){
    $idEnlace = isset($_POST["idEnlace"]) ? $_POST["idEnlace"] : "";
    $Results = $GLOBALS['pdo']->prepare("SELECT * FROM padrones AS T1 
    INNER JOIN detalle_padron AS T2 USING (Id_Padron)
    WHERE T1.Id_Enlace = $idEnlace");
    $execute = $Results -> execute();
    if ($Results -> rowCount() > 0 ) {
        // echo "ya existe";
        echo "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>El Enlace contiene usuarios  \" data-status=\"warning\" data-pos=\"top-center\"></button>";
    }else{
        echo "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>Se puede Borrar!  \" data-status=\"success\" data-pos=\"top-center\"></button>"; 
    }
    ?> 
    <script>
      
        jQuery(function(){
            jQuery('#Respuesta').click();
        });
        principalEnlacesOP();
    </script>
     <?php 
}
function CrearEnlaceNWUser(){
    // enlace
    $Id_Proyecto = $_SESSION['id_proyecto'];
    $NombreEnlace = isset($_POST["NombreEnlace"]) ? $_POST["NombreEnlace"] : "";    
    // contactos
    $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
    $APP = isset($_POST["APP"]) ? $_POST["APP"] : "";
    $APM = isset($_POST["APM"]) ? $_POST["APM"] : "";
    $Direccion = isset($_POST["Direccion"]) ? $_POST["Direccion"] : "";
    $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";
    $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
    $Contraseña = isset($_POST["Contraseña"]) ? $_POST["Contraseña"] : "";
    $Seccion = isset($_POST["Seccion"]) ? $_POST["Seccion"] : "";
    // 
    $User_New = Enlace::CrearUser(3,$Nombre,$APP,$APM,$Direccion,$Telefono,$Correo,$Contraseña,0, $Seccion,0,$Id_Proyecto);
    // id usuario registrado
    $Results = $GLOBALS['pdo']->prepare("SELECT @@identity AS Id_Contacto");
    $execute = $Results -> execute();
    while( $row = $Results -> fetch()){
        $id_User = trim($row[0]);
    } 
    $Enlace_New = Enlace::CrearEnlace($Id_Proyecto,$id_User,3,$NombreEnlace);
     echo $Enlace_New ?  
     "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>No se pudo registrar el enlace  \" data-status=\"danger\" data-pos=\"top-center\"></button>" : 
    "<button class=\"md-btn\" id=\"Respuesta\" data-message=\"<a href='#' class='notify-action'></a>Enlace registrado con exito!\" data-status=\"success\" data-pos=\"top-center\"></button>"; 
    // Id enlace
    $Results = $GLOBALS['pdo']->prepare("SELECT @@identity AS Id_Enlace");
    $execute = $Results -> execute();
    while( $row = $Results -> fetch()){
        $Id_enlace = trim($row[0]);
    }    
    $Enlace_New = Enlace::UpdateEnlace($id_User,$Id_enlace);
    ?> 
    <script>
      
        jQuery(function(){
            jQuery('#Respuesta').click();
        });
        principalEnlacesOP();
    </script>
     <?php 
}
?>