<?php
    // include_once('../../../config/database.php');
    if(file_exists('../../../config/database.php'))
        include_once('../../../config/database.php');
    if(file_exists('../../../../config/database.php'))
        include_once('../../../../config/database.php');
    $pdo = Database::getInstance()->getPdoObject();

class Contactos{
	private static $instance = null;

    public function __construct()
    {
        self::getInstance();
    }

    public static function getInstance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Contactos();
        }

        return self::$instance;
    }
    public function Crear($idPerfil,$nombre,$app,$apm,$direccion,$telfono,$correo,$contraseña,$idCaombio,$Seccion,$enlace,$proyecto,$sexo,$año){
        try{
            // $stmt = $GLOBALS['pdo']->prepare("INSERT INTO contactos (Id_perfil,Nombre,Ape_Pat,APe_Mat,Direccion,Telefono,Correo,Psw,id_cambio,Seccion)
            // SELECT * FROM (SELECT '$idPerfil','$nombre','$app','$apm','$direccion','$telfono','$correo','$contraseña','$idCaombio','$Seccion') AS tmp
            // WHERE NOT EXISTS (
            //     SELECT Correo,id_cambio FROM contactos WHERE Correo = '$correo' AND  id_cambio !='0'
            // ) LIMIT 1;");
            // $stmt->execute();
            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO contactos(Id_perfil,Nombre,Ape_Pat,APe_Mat,Direccion,Telefono,Correo,Psw,id_cambio,Seccion,Id_Enlace,Id_Proyecto,Sexo,Nacimiento) 
            VALUES ('$idPerfil','$nombre','$app','$apm','$direccion','$telfono','$correo','$contraseña','$idCaombio','$Seccion','$enlace','$proyecto','$sexo','$año')");
            $stmt->execute();
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }    
    // 
    function Editar($idPersona,$nombre,$apellidoP,$apellidoM,$correo,$telefono,$user,$pass,$enlace){
        try{        
           $stmt = $GLOBALS['pdo']->prepare("UPDATE recolectores SET Nombre='$nombre',App='$apellidoP',Apm='$apellidoM',Correo='$correo',Telefono='$telefono', User ='$user', Contraseña='$pass', Id_Enlace='$enlace' WHERE Id=$idPersona");    
           $stmt->execute();
           return $stmt;
       }
       catch (PDOException $err)
       {
           return $err->getMessage();
       }
   }
   public function Borrar($id){
        try{
            $stmt = $GLOBALS['pdo']->prepare("DELETE FROM contactos WHERE Id_Contacto ='$id'");
            $stmt->execute();

            return $stmt;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }
    public function BorrarDetalle($id_padron,$idPersona){
        try{
            $stmt = $GLOBALS['pdo']->prepare("DELETE FROM detalle_padron WHERE Id_Padron='$id_padron' AND Id_Contacto='$idPersona' ");
            $stmt->execute();

            return $stmt;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }
    // 
    public function GetUser($idPersona){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM contactos AS T1 WHERE T1.Id_Contacto = '$idPersona' ");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $options = '    
        <div class="uk-grid" data-uk-grid-margin>        
            <div class="uk-width-medium-1-3">
                <label>Nombre*</label>
                <input type="text" class="md-input" id="input_nombre_PA" maxlength="60" required disabled style="cursor: no-drop;" value="'.$row['Nombre'].'" />
            </div>
            <div class="uk-width-medium-1-3">
                <label>Apellido Paterno*</label>
                <input type="text" class="md-input" id="input_ape_pat_PA" maxlength="60" required disabled readonly style="cursor: no-drop;" value="'.$row['Ape_Pat'].'" />
            </div>
            <div class="uk-width-medium-1-3">
                <label>Apellido Materno</label>
                <input type="text" class="md-input" id="input_ape_mat_PA" maxlength="60" disabled readonly style="cursor: no-drop;" value="'.$row['APe_Mat'].'" />
            </div>
            <div class="uk-width-medium-1-1">
                <label>Direccion*</label>
                <input type="text" class="md-input" id="input_direccion_PA_nw" maxlength="400" required  value="'.$row['Direccion'].'" />
            </div>            
            <div class="uk-width-medium-1-2">                
                <label for="masked_phone">Phone</label>
                <input class="md-input masked_input" id="input_tel_PA" type="text" data-inputmask="\'mask\': \'999 9999 999\'" data-inputmask-showmaskonhover="false"   value="'.$row['Telefono'].'" />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Seccion *</label>
                <input type="text" class="md-input" id="input_Seccion_PA" maxlength="60" required  value="'.$row['Seccion'].'" />
            </div>            
            <div class="uk-width-medium-1-2">     
            <i class="material-icons"></i>
            <label for="masked_email">Email*</label>
                <input class="md-input masked_input" id="input_email_PA" type="text" data-inputmask="\'alias\': \'email\'" data-inputmask-showmaskonhover="false" disabled readonly style="cursor: no-drop;" value="'.$row['Correo'].'" />
            </div>            
            <div class="uk-width-medium-1-2"  data-uk-grid-match="{target:\'.md-card\'}">
            <h3 class="heading_a">Password</h3>
                <input type="password" class="md-input" id="input_contraseña_PA" maxlength="20" required value="" />                
                <a href="" class="uk-form-password-toggle" data-uk-form-password Style=" position: relative;">show</a>
            </div>
            <div class="uk-width-medium-1-2">
                    <div class="uk-form-row parsley-row">;
                        <label for="gender" class="uk-form-label">Sexo<span class="req">*</span></label>';
                        if ($row['Sexo'] == 'M') {
                            $options .='
                                <span class="icheck-inline">
                                    <input type="radio" name="val_radio_gender" id="val_radio_h" value=\'H\' data-md-icheck  />
                                    <label for="val_radio_male" class="inline-label">Hombre</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" name="val_radio_gender" id="val_radio_male" value=\'M\' data-md-icheck checked/>
                                    <label for="val_radio_female" class="inline-label">Mujer</label>
                                </span>';
                        }else{
                            $options .='
                                <span class="icheck-inline">
                                    <input type="radio" name="val_radio_gender" id="val_radio_h" value=\'H\' data-md-icheck checked />
                                    <label for="val_radio_male" class="inline-label">Hombre</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" name="val_radio_gender" id="val_radio_male" value=\'M\' data-md-icheck />
                                    <label for="val_radio_female" class="inline-label">Mujer</label>
                                </span>';
                        }
                        
                        $options .= '
                    </div>
                </div>       
            <div class="uk-width-medium-1-2">
                <label for="masked_date">Date*</label>
                <input class="md-input masked_input" id="masked_date" required type="text" data-inputmask="\'alias\': \'mm/dd/yyyy\'" data-inputmask-showmaskonhover="false" value="'.$row['Nacimiento'].'" />
            </div>
            <div class="uk-width-medium-1-3" style="visibility: hidden; height: 0px;">
                <label>usuario*</label>
                <input type="password" class="md-input" id="input_id" maxlength="20" required disabled readonly style="cursor: no-drop;" value="'.$idPersona.'" />
            </div>
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
            ';
            // <a href="" class="uk-form-password-toggle" data-uk-form-password Style=" position: relative;">show</a>
            }
            $response = array(
                'success' => TRUE,
                'options' => $options
            );

            header('Content-Type: application/json');
            return $response;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }
  
}
?>