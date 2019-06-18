<?php 
require_once "../modelo/contactos.php";
require_once "../modelo/padrones.php";
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();

$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
function PadronBL(){
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
                <input type="text" class="md-input" id="input_direccion_PA_nw" maxlength="250" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
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
            <div class="uk-width-medium-1-2">
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
    $response2 = array(
        'success' => TRUE,
        'options' => $options
    );
    header('Content-Type: application/json');

    echo json_encode($response2);
}
function PadronNW(){
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
        <label>Direccion</label>
        <input type="text" class="md-input" id="input_direccion_PA_nw"  maxlength="250" />
    </div>            
    <div class="uk-width-medium-1-2">        
        <label for="masked_phone">Phone</label>
        <input class="md-input masked_input" id="input_tel_PA" type="text" data-inputmask="\'mask\': \'999 9999 999\'" data-inputmask-showmaskonhover="false" />
    </div>
    <div class="uk-width-medium-1-2">
        <label>Seccion*</label>        
        <input class="md-input masked_input" id="input_Seccion_PA" type="text" data-inputmask="\'alias\': \'numeric\'" data-inputmask-showmaskonhover="true" />
    </div>
    <div class="uk-width-medium-1-2">
        <div class="uk-form-row parsley-row">
            <label for="gender" class="uk-form-label">Sexo<span class="req">*</span></label>
            <span class="icheck-inline">
                <input type="radio" name="val_radio_gender" id="val_radio_male" value=\'H\' data-md-icheck checked />
                <label for="val_radio_male" class="inline-label">Hombre</label>
            </span>
            <span class="icheck-inline">
                <input type="radio" name="val_radio_gender" id="val_radio_male" value=\'M\' data-md-icheck />
                <label for="val_radio_female" class="inline-label">Mujer</label>
            </span>
        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <label for="masked_email">Email</label>
        <input class="md-input masked_input" id="input_email_PA" type="text" data-inputmask="\'alias\': \'email\'" data-inputmask-showmaskonhover="false" />
    </div>
    <div class="uk-width-medium-1-2">
        <label for="masked_date">Date*</label>
        <input class="md-input masked_input" id="masked_date" type="text" required data-inputmask="\'alias\': \'mm/dd/yyyy\'" data-inputmask-showmaskonhover="false" />
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
function PadronUP(){
    $IdUsuario = isset($_POST["idUser"]) ? $_POST["idUser"] : "";
    $datos =Contactos::GetUser($IdUsuario);    
    echo json_encode($datos);
}
function BusquedaUserPadron(){
    $IdUsuario = isset($_POST["idUser"]) ? $_POST["idUser"] : "";
    // echo "holis";
    ?>
    <div id="busquedaForm_PA">
      <form class="uk-form-stacked" method="POST" action="?" id="Busqueda_User_Create_PA" name="Busqueda_User_Create_PA">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <label>Nombre</label>
                <input type="text" class="md-input" id="input_nombre_Busq_PA" maxlength="60"  value=""    />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Paterno</label>
                <input type="text" class="md-input" id="input_ape_pat_Busq_PA" maxlength="60" value=""  />
            </div>    
            <div class="uk-width-medium-1-2">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_Busq_PA" maxlength="60" value=""  />
            </div>          
        </div>
        <br><br>
        <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
        <button type="submit"  onclick="Busq_User_Create_PA( '1');" class="md-btn md-btn-primary"  >Busqueda</button>
    </form>
</div>
    <div class="uk-grid" data-uk-grid-margin id="ResultadosBusqCrear_PA" style='display:none;' >   
    </div>
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
<?php
}
function AgregarUserPA(){
    $id_Segmento = $_SESSION['Id_Segmento'];//Segmento
    $Id_EnlaceOP = $_SESSION['Id_EnlaceOP'];
    $id_proyecto = $_SESSION['id_proyecto'];
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
    // // 
    $User_New = Contactos::Crear(4,$Nombre,$APP,$APM,$Direccion,$Telefono,$Correo,$Contraseña,$idU, $Seccion,$Id_EnlaceOP,$id_proyecto,$sexo,$año);
    // id usuario registrado
    $Results = $GLOBALS['pdo']->prepare("SELECT @@identity AS Id_Contacto");
    $execute = $Results -> execute();
    while( $row = $Results -> fetch()){
        $id_User = trim($row[0]);
    }  
    // 
    $options="";
    $NombrePadron = isset($_POST["NomPadron"]) ? $_POST["NomPadron"] : "";
    $PA_New = Padrones::Crear($NombrePadron,$id_Segmento,$id_User);
        $PA_New ? $options .='<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'></a>No se pudo registrar padron  " data-status="danger" data-pos="top-center">Danger</button>' : 
        $options .= '<button class="md-btn" id="RespuestaCreateUserPadron" data-message="<a href=\'#\' class=\'notify-action\'></a>Padron agregado con exito " data-status="success" data-pos="top-center">Success</button>'; 
        $options .='                 
        <script>
        jQuery(function(){
            jQuery(\'#RespuestaCreateUserPadron\').click();
        });        
    </script> ';
    $response = array(
        'success' => TRUE,
        'options' => $options
    );
    header('Content-Type: application/json');

    echo json_encode($response);
}
?>