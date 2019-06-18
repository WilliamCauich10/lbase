
<div id="page_content_inner">
    <div  class="md-card">
        <div class="md-card-content">
            <form class="uk-form-stacked" method="POST" action="?" id="formSaveUser" name="formSaveUser"> 
            <div class="uk-grid" data-uk-grid-margin>        
                <div class="uk-width-medium-1-1">
                        <label>Nombre Padron*</label>
                        <input type="text" class="md-input" id="input_nombre_Padron" maxlength="200" required  />
                </div>  
                <div class="uk-width-medium-1-4">
                                <a class="md-btn md-btn-primary md-btn-block md-btn-wave-light" href="#ModalCrearContac" data-uk-modal="{ center:true }" onclick=" modal_CreatePadron()">Busqueda</a>
                </div>
            </div>        
            <br>
                <div id="form1"></div>
            <button type="button" class="md-btn md-btn-wave" onclick="regresar('app/PA/vista/view_enlaces.php')">Regresar</button>
            <button type="submit" onclick="formSaveUserbtn();" class="md-btn md-btn-primary" id="GuardarPadron" >Guardar</button>
            </form>
        </div>    
    </div>
</div>
<div id="resultados" ></div>
<!-- Modal -->
<div class="uk-modal" id="ModalCrearContac">
    <div class="uk-modal-dialog" style="top:0px;">
        <div class="uk-overflow-container">
            <div id="ModalCrearContacEO">
            </div>
        </div>
    </div>
</div>