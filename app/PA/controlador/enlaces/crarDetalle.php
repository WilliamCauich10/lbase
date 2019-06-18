<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
require_once "../../modelo/padrones.php";
require_once "../../modelo/contactos.php";
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
function DetalleBL(){
    $options = '    
        <div class="uk-grid" data-uk-grid-margin>        
            <div class="uk-width-medium-1-3">
                <label>Nombre*</label>
                <input type="text" class="md-input" id="input_nombre_PA" maxlength="60" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-3">
                <label>Apellido Paterno*</label>
                <input type="text" class="md-input" id="input_ape_pat_PA" maxlength="60" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-3">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_PA" maxlength="60" disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Direccion*</label>
                <input type="text" class="md-input" id="input_direccion_PA_nw"  maxlength="250" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>            
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0CD;</i>
                <label for="masked_phone">Phone</label>
                <input class="md-input masked_input" id="input_tel_PA" type="text" data-inputmask="\'mask\': \'999 9999 999\'" data-inputmask-showmaskonhover="false" disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-1">
                <label>Seccion *</label>
                <input type="text" class="md-input" id="input_Seccion_PA" maxlength="60" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0BE;</i>
                <label for="masked_email">Email*</label>
                <input class="md-input masked_input" id="input_email_PA" type="text" data-inputmask="\'alias\': \'email\'" data-inputmask-showmaskonhover="false" disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-2" style="visibility: hidden; height: 0px;">
                <label>Cotraseña*</label>
                <input type="password" class="md-input" id="input_contraseña_PA" maxlength="20" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-3" style="visibility: hidden; height: 0px;">
                <label>usuario*</label>
                <input type="password" class="md-input" id="input_id" maxlength="20" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" value="0" />
            </div>
        </div>
        <br><br>    
            ';
    $response = array(
        'success' => TRUE,
        'options' => $options
    );
    header('Content-Type: application/json');

    echo json_encode($response);
}
function BusquedaDetalle(){
?>
<div id="busquedaForm_EO">
      <form class="uk-form-stacked" method="POST" action="?" id="Busqueda_User_Create_EO" name="Busqueda_User_Create_EO">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <label>Nombre </label>
                <input type="text" class="md-input" id="input_nombre_Busq" maxlength="60" value="" />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Paterno </label>
                <input type="text" class="md-input" id="input_ape_pat_Busq" maxlength="60"  value=""  />
            </div>            
            <div class="uk-width-medium-1-2">
                <label>Apellido Materno </label>
                <input type="text" class="md-input" id="input_ape_mat_Busq" maxlength="60"  value=""  />
            </div>            
        </div>
        <br><br>
        <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
        <button type="submit"  onclick="Busq_User_Create_EO(0);" class="md-btn md-btn-primary"  >Busqueda</button>
    </form>
</div>

    <div class="uk-grid" data-uk-grid-margin id="ResultadosBusqCrear_EO" style='display:none;' >   
    </div>
    <div class="uk-grid" data-uk-grid-margin id="formEO" style='display:none;' >   
    </div>
<?php
}
function AgregarUserDetalle(){
    $Id_EnlaceOP = $_SESSION['Id_EnlaceOP'];
    $id_proyecto = $_SESSION['id_proyecto'];
    // 
    $idPadron = isset($_POST["idpadron"]) ? $_POST["idpadron"] : "";
    $idU = isset($_POST["idU"]) ? $_POST["idU"] : ""; //id cambio    
    // Datos usuario
    $Nombre = isset($_POST["Nombre"]) ? $_POST["Nombre"] : "";
    $APP = isset($_POST["APP"]) ? $_POST["APP"] : "";
    $APM = isset($_POST["APM"]) ? $_POST["APM"] : "";
    $Direccion = isset($_POST["Direccion"]) ? $_POST["Direccion"] : "";
    $Telefono = isset($_POST["Telefono"]) ? $_POST["Telefono"] : "";
    $Correo = isset($_POST["Correo"]) ? $_POST["Correo"] : "";
    $Contraseña = isset($_POST["Contraseña"]) ? $_POST["Contraseña"] : "";
    $Seccion = isset($_POST["Seccion"]) ? $_POST["Seccion"] : "";
    $sexo = isset($_POST["sexo"]) ? $_POST["sexo"] : "";
    $año = isset($_POST["nacimiento"]) ? $_POST["nacimiento"] : "";
    // 
    $options="";
    // Verifiacar que el usuario no exita en ese padron
    $Results = $GLOBALS['pdo']->prepare("SELECT * FROM detalle_padron AS D
    WHERE D.Id_Padron = '$idPadron' AND D.Id_Contacto = '$idU'");
    $execute = $Results -> execute();
    if ($Results -> rowCount() > 0 ) {
        $options .='<button class="md-btn" id="RespuestaCreateDetalle" data-message="<a href=\'#\' class=\'notify-action\'></a>El usuario ya existe en este padron" data-status="danger" data-pos="top-center">Danger</button>' ;
    }else{
        $Usr_Pa = $GLOBALS['pdo']->prepare("SELECT T1.* FROM padrones AS T1 
            INNER JOIN contactos AS T2 ON T1.Id_Persona = T2.Id_Contacto
            WHERE T1.Id_Padron = '$idPadron' AND T2.id_cambio = '$idU' AND T2.Id_perfil >3;");
        $execute2 = $Usr_Pa -> execute();
        if ($Usr_Pa -> rowCount() > 0 ) {
            $options .='<button class="md-btn" id="RespuestaCreateDetalle" data-message="<a href=\'#\' class=\'notify-action\'></a>El usuario es el responsable del padron" data-status="danger" data-pos="top-center">Danger</button>' ;
        }else{    
            if ($idU=='-1') {
                $idU='0';
            }        
        // 
        $User_New = Contactos::Crear(5,$Nombre,$APP,$APM,$Direccion,$Telefono,$Correo,$Contraseña,$idU, $Seccion,$Id_EnlaceOP,$id_proyecto,$sexo,$año);
        // id usuario registrado
        $Results = $GLOBALS['pdo']->prepare("SELECT @@identity AS Id_Contacto");
        $execute = $Results -> execute();
        while( $row = $Results -> fetch()){
            $id_User = trim($row[0]);
        } 
        $De_New = Padrones::CrearDetalle($idPadron,$id_User);
            $De_New ?  
             $options .='<button class="md-btn" id="RespuestaCreateDetalle" data-message="<a href=\'#\' class=\'notify-action\'></a>No se pudo registrar el usuario" data-status="danger" data-pos="top-center">Danger</button>' : 
             $options .='<button class="md-btn" id="RespuestaCreateDetalle" data-message="<a href=\'#\' class=\'notify-action\'></a>Usuario registrado con exito! " data-status="success" data-pos="top-center">Success</button>'; 
        } //else usuario responsable Padron
    }//else usuario repetido detalle
    $options .='                 
        <script>
        jQuery(function(){
            jQuery(\'#RespuestaCreateDetalle\').click();
        });        
    </script> ';
    $response = array(
        'success' => TRUE,
        'options' => $options
    );
    header('Content-Type: application/json');

    echo json_encode($response);
}
function DetalleNW(){
    $options = '    
    <div class="uk-grid" data-uk-grid-margin>        
    <div class="uk-width-medium-1-3">
        <label>Nombre*</label>
        <input type="text" class="md-input" id="input_nombre_PA" maxlength="60" required />
    </div>
    <div class="uk-width-medium-1-3">
        <label>Apellido Paterno*</label>
        <input type="text" class="md-input" id="input_ape_pat_PA" maxlength="60" required />
    </div>
    <div class="uk-width-medium-1-3">
        <label>Apellido Materno</label>
        <input type="text" class="md-input" id="input_ape_mat_PA" maxlength="60" />
    </div>
    <div class="uk-width-medium-1-2">
        <label>Direccion*</label>
        <input type="text" class="md-input" id="input_direccion_PA_nw"  maxlength="250" required />
    </div>            
    <div class="uk-width-medium-1-2">
        
        <label for="masked_phone">Phone</label>
        <input class="md-input masked_input" id="input_tel_PA" type="text" data-inputmask="\'mask\': \'999 9999 999\'" data-inputmask-showmaskonhover="false" />
    </div>
    <div class="uk-width-medium-1-1">
        <label>Seccion *</label>
        <input type="text" class="md-input" id="input_Seccion_PA" maxlength="60" required />
    </div>
    <div class="uk-width-medium-1-2">
        <i class="material-icons"></i>
        <label for="masked_email">Email*</label>
        <input class="md-input masked_input" id="input_email_PA" type="text" data-inputmask="\'alias\': \'email\'" data-inputmask-showmaskonhover="false" />
    </div>
    <div class="uk-width-medium-1-3" style="visibility: hidden; height: 0px;">
        <label>Cotraseña*</label>
        <input type="password" class="md-input" id="input_contraseña_PA" maxlength="20" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" value="N/A" />
    </div>
    <div class="uk-width-medium-1-3" style="visibility: hidden; height: 0px;">
        <label>usuario*</label>
        <input type="password" class="md-input" id="input_id" maxlength="20" required  value="0" />
    </div>
</div>
<br><br>   
<script src="assets/js/common.min.js"></script>
<!-- uikit functions -->
<script src="assets/js/uikit_custom.min.js"></script>
<!-- altair common functions/helpers -->
<script src="assets/js/altair_admin_common.min.js"></script>

<!-- page specific plugins -->
<!-- ionrangeslider -->
<script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
<!-- htmleditor (codeMirror) -->
<script src="assets/js/uikit_htmleditor_custom.min.js"></script>
<!-- inputmask-->
<script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
<!--  forms advanced functions -->
<script src="assets/js/pages/forms_advanced.min.js"></script>    
            ';
    $response = array(
        'success' => TRUE,
        'options' => $options
    );
    header('Content-Type: application/json');

    echo json_encode($response);
}
?>