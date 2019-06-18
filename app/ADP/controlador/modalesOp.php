<?php 
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$tipo();
// echo $tipo;
// Busqueda usuarios para enlaces operativos
function Busq_Crear(){
?>
<div id="busquedaForm">
      <form class="uk-form-stacked" method="POST" action="?" id="Busqueda_User_Create_ADP" name="Busqueda_User_Create_ADP">
        <!-- <button type="button" class="uk-modal-close uk-close"></button> -->
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <label>Nombre</label>
                <input type="text" class="md-input" id="input_nombre_Busq" maxlength="60" value="" />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Paterno*</label>
                <input type="text" class="md-input" id="input_ape_pat_Busq" maxlength="60" value="" />
            </div>    
            <div class="uk-width-medium-1-2">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_Busq_PA" maxlength="60" value=""  />
            </div>         
        </div>
        <br>
        <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
        <button type="submit"  onclick="Busq_User_Create();" class="md-btn md-btn-primary"  >Busqueda</button>
    </form>
</div>
<!-- -->
    <div class="uk-grid" data-uk-grid-margin id="ResultadosBusqCrear" style='display:none;' >   
    </div>
    <div class="uk-grid" data-uk-grid-margin id="formOpt" style='display:none;' >   
    </div>
    <!-- <div class="uk-grid" data-uk-grid-margin id="Editar_op" style='display:none;' >   
    </div> -->
<?php 
}
function Crear_enlaceOp1(){
    ?>
    <form class="uk-form-stacked" method="POST" action="?" id="CrearCliente_REC" name="CrearCliente_REC">
        <!-- <button type="button" class="uk-modal-close uk-close"></button> -->
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-1">
                <label>Nombre*</label>
                <input type="text" class="md-input" id="input_nombre_REC" maxlength="60" required  />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Paterno*</label>
                <input type="text" class="md-input" id="input_ape_pat_REC" maxlength="60" required  />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_REC" maxlength="60" />
            </div>
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0BE;</i>
                <label for="masked_email">Email*</label>
                <input class="md-input masked_input" id="input_email_REC" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" />
            </div>
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0CD;</i>
                <label for="masked_phone">Phone</label>
                <input class="md-input masked_input" id="input_tel_REC" type="text" data-inputmask="'mask': '999 9999 999'" data-inputmask-showmaskonhover="false"  />
            </div>
            <br><br><br><br>
            <div class="uk-width-medium-1-2">
                <label>Nombre de Usuario*</label>
                <input type="text" class="md-input" id="input_user_name_REC" maxlength="30" required  />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Cotraseña*</label>
                <input type="password" class="md-input" id="input_contraseña_REC" maxlength="20" required />
            </div>
        </div>
        <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
        <!-- <button type="submit" onclick="RegistrarREC(<?= $Id_User ?>);" class="md-btn md-btn-primary"  >Guardar</button> -->
    </form>
<?php 
}
?>
