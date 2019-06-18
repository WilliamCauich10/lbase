<div id="page_content_inner">
    <div  class="md-card">
        <div class="md-card-content">
            <form class="uk-form-stacked" method="POST" action="?" id="formoperador" name="formoperador"> 
            <div class="uk-grid" data-uk-grid-margin>        
                <!-- <div class="uk-width-medium-1-1">
                        <label>Nombre Segmento*</label>
                        <input type="text" class="md-input" id="input_nombre_Padron" maxlength="200" required  />
                </div>   -->
                <div class="uk-width-medium-1-4">
                                <a class="md-btn md-btn-primary md-btn-block md-btn-wave-light" href="#ModalCrearOperador" data-uk-modal="{ center:true }" onclick=" modal_CreateOperador()">Busqueda</a>
                </div>
             
            </div>        
            <br>
                <div id="form1">
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
                <input type="text" class="md-input" id="input_direccion_PA_nw"  maxlength="250" required disabled style="background-color: gainsboro;cursor: no-drop;" />
            </div>            
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0CD;</i>
                <label for="masked_phone">Phone</label>
                <input class="md-input masked_input" id="input_tel_PA" type="text" data-inputmask="'mask': '999 9999 999'" data-inputmask-showmaskonhover="false" disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-1">
                <label>Seccion *</label>
                <input type="text" class="md-input" id="input_Seccion_PA" maxlength="60" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-2">
                <i class="material-icons">&#xE0BE;</i>
                <label for="masked_email">Email*</label>
                <input class="md-input masked_input" id="input_email_PA" type="text" data-inputmask="'alias': 'email'" data-inputmask-showmaskonhover="false" disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
            </div>
            <div class="uk-width-medium-1-2">
                <label>Cotraseña*</label>
                <input type="password" class="md-input" id="input_contraseña_PA" maxlength="20" required disabled readonly style="background-color: gainsboro;cursor: no-drop;"  />
            </div>
            <div class="uk-width-medium-1-2">
                <div class="uk-form-row parsley-row">
                    <label for="gender" class="uk-form-label">Sexo<span class="req">*</span></label>
                    <span class="icheck-inline">
                        <input type="radio" name="val_radio_gender" id="val_radio_male1" value='H' data-md-icheck checked disabled readonly style="background-color: gainsboro;cursor: no-drop;" />
                        <label for="val_radio_male" class="inline-label">Hombre</label>
                    </span>
                    <span class="icheck-inline">
                        <input type="radio" name="val_radio_gender" id="val_radio_male" value='M' data-md-icheck disabled readonly style="background-color: gainsboro;cursor: no-drop;"  />
                        <label for="val_radio_female" class="inline-label">Mujer</label>
                    </span>
                </div>
            </div>
            <div class="uk-width-medium-1-2">
                <label for="masked_date">Date*</label>
                <input class="md-input masked_input" id="masked_date" type="text" required data-inputmask="'alias': 'mm/dd/yyyy'" data-inputmask-showmaskonhover="false"  disabled readonly style="background-color: gainsboro;cursor: no-drop;"  />
            </div>
            <div class="uk-width-medium-1-3" style="visibility: hidden; height: 0px;">
                <label>usuario*</label>
                <input type="password" class="md-input" id="input_id" maxlength="20" required disabled readonly style="background-color: gainsboro;cursor: no-drop;" value="0" />
            </div>            
        </div>
        <br><br> 
                </div>
            <!-- <button type="button" class="md-btn md-btn-wave" onclick="regresar('app/EO/vista/view_enlaces.php')">Regresar</button> -->
            <button type="submit" onclick="formoperadorbtn();" class="md-btn md-btn-primary" id="GuardarPadron" >Guardar</button>
            </form>
        </div>    
    </div>
</div>
<div id="resultados" ></div>
<!-- Modal -->
<div class="uk-modal" id="ModalCrearOperador">
    <div class="uk-modal-dialog" style="top:0px;">
        <div class="uk-overflow-container">
            <div id="ModalCrearOperadorEO">
            </div>
        </div>
    </div>
</div>
 <!-- ionrangeslider -->
 <!-- <script src="bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script> -->
    <!-- htmleditor (codeMirror) -->
    <!-- <script src="assets/js/uikit_htmleditor_custom.min.js"></script> -->
    <!-- inputmask-->
    <!-- <script src="bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script> -->

    <!--  forms advanced functions -->
    <!-- <script src="assets/js/pages/forms_advanced.min.js"></script> -->
    <!-- page specific plugins -->
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