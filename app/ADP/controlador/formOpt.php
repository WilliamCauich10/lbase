<?php 
include_once('../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
// Crear usuarios Enlaces
function Crear(){
    ?>
    <form class="uk-form-stacked" method="POST" action="?" id="formCrearEnUser" name="formCrearEnUser">
        <!-- <button type="button" class="uk-modal-close uk-close"></button> -->
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-1">
                <label>Nombre de Enlace*</label>
                <input type="text" class="md-input" id="input_nombre_Enlace_Opt" maxlength="60" required />
            </div>    
            <div class="uk-width-medium-1-1">
                <label>Nombre*</label>
                <input type="text" class="md-input" id="input_nombre_Opt" maxlength="60" required />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Paterno*</label>
                <input type="text" class="md-input" id="input_ape_pat_Opt" maxlength="60" required/>
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_Opt" maxlength="60"/>
            </div>
            <div class="uk-width-medium-1-2">
                <label>Direccion*</label>
                <input type="text" class="md-input" id="input_direccion_opt_nw" maxlength="30" required  />
            </div>            
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0CD;</i>
                <label for="masked_phone">Phone</label>
                <input class="md-input masked_input" id="input_tel_Opt" type="text" data-inputmask="'mask': '999 9999 999'" data-inputmask-showmaskonhover="false"/>
            </div>
            <div class="uk-width-medium-1-1">
                <label>Seccion *</label>
                <input type="text" class="md-input" id="input_Seccion_PA" maxlength="60"  required  />
            </div>
            <br><br><br><br>
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0BE;</i>
                <label for="masked_email">Email*</label>
                <input class="md-input masked_input" id="input_email_Opt" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false"/>
            </div>
            <div class="uk-width-medium-1-2">
                <label>Cotraseña*</label>
                <input type="password" class="md-input" id="input_contraseña_Opt" maxlength="20" required/>
            </div>
        </div>
        <br>
        <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
        <button type="submit" onclick="GuardarFormCreNW();" class="md-btn md-btn-primary"  >Guardar</button>
    </form>
<?php
}
function CreateUserUP(){
    $Id_user = isset($_POST["idUser"]) ? $_POST["idUser"] : "";
    $Results = $GLOBALS['pdo']-> prepare("SELECT * FROM contactos AS T1 WHERE T1.Id_Contacto ='$Id_user' AND T1.id_cambio ='0'");
    $execute = $Results -> execute();
    while( $row = $Results -> fetch()){
        // $idContacto = $row['Id_Contacto'];
        $nombre = $row['Nombre'];
        $App = $row['Ape_Pat'];
        $Apm = $row['APe_Mat'];
        $Direccion = $row['Direccion'];
        $Telefono = $row['Telefono'];
        $Correo = $row['Correo'];
        $Pass = $row['Psw'];
        $Seccion = $row['Seccion'];
    }
    ?>
    <form class="uk-form-stacked" method="POST" action="?" id="formCrearUPOpt" name="formCrearUPOpt">
        <!-- <button type="button" class="uk-modal-close uk-close"></button> -->
        <div class="uk-grid" data-uk-grid-margin>  
        <div class="uk-width-medium-1-1">
                <label>Nombre de Enlace*</label>
                <input type="text" class="md-input" id="input_nombre_Enlace_Opt" maxlength="60" required />
            </div>     
            <div class="uk-width-medium-1-1">
                <label>Nombre*</label>
                <input type="text" class="md-input" id="input_nombre_Opt" maxlength="60" value="<?= $nombre ?>" required />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Paterno*</label>
                <input type="text" class="md-input" id="input_ape_pat_Opt" maxlength="60" value="<?= $App ?>" required/>
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_Opt" maxlength="60" value="<?= $Apm ?>" />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Direccion*</label>
                <input type="text" class="md-input" id="input_direccion_opt_nw" maxlength="30" value="<?= $Direccion ?>" required  />
            </div>            
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0CD;</i>
                <label for="masked_phone">Phone</label>
                <input class="md-input masked_input" id="input_tel_Opt" type="text" value="<?= $Telefono ?>" />
            </div>
            <div class="uk-width-medium-1-1">
                <label>Seccion *</label>
                <input type="text" class="md-input" id="input_Seccion_PA" maxlength="60" value="<?= $Seccion ?>" required  />
            </div>
            <br><br><br><br>
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0BE;</i>
                <label for="masked_email">Email*</label>
                <input class="md-input masked_input" id="input_email_Opt" type="text" value="<?= $Correo ?>"/>
            </div>
            <div class="uk-width-medium-1-2">
                <label>Cotraseña*</label>
                <input type="password" class="md-input" id="input_contraseña_Opt" value="<?= $Pass ?>" required/>
            </div>
        </div>
        <br>
        <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
        <button type="submit" onclick="GuardarFormCreUP(<?= $Id_user ?>);(function(modal){ modal = UIkit.modal.blockUI('<div class=\'uk-text-center\'>Wait 5 sec...<br/><img class=\'uk-margin-top\' src=\'assets/img/spinners/spinner.gif\' alt=\'\'>'); setTimeout(function(){ modal.hide() }, 5000) })();" class="md-btn md-btn-primary"  >Guardar</button>
    </form>
<?php
}
?>