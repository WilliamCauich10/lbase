<?php 
$idPadron = isset($_POST['idPadron']) ? $_POST['idPadron'] : "";
$nombre = isset($_POST['nombrePA']) ? $_POST['nombrePA'] : "";
$_SESSION['id_P'] = $idPadron;//id Padron
$_SESSION['NPadrom'] = $nombre;//NPadrom
?>
<script>
  id_P = <?php echo $idPadron; ?>;
  Nm_P = '<?php echo  $nombre; ?>';
</script>
<div id="page_content_inner">
    <div  class="md-card">
        <div class="md-card-content">
            <form class="uk-form-stacked" method="POST" action="?" id="formSaveDetalle" name="formSaveDetalle"> 
            <div class="uk-grid" data-uk-grid-margin>        
                <div class="uk-width-medium-1-1">
                        <label>Nombre Padron <?= $_SESSION['id_P']  ?></label>
                        <input type="text" class="md-input" id="input_nombre_Padron" maxlength="200" value="<?= $nombre ?>" disabled readonly style="cursor: no-drop;"  />
                </div>  
                <div class="uk-width-medium-1-4">
                    <a class="md-btn md-btn-primary md-btn-block md-btn-wave-light" href="#ModalCrearDetalle" data-uk-modal="{ center:true }" onclick=" modal_CreateDetalle()">Busquedar Contactos</a>
                </div>
            </div>        
            <br>
                <div id="form1"></div>
                
                <button type="button" class="md-btn md-btn-wave" onclick="regresar2('app/PA/vista/view_enlaces.php','Dia de la bandera',52);">Regresar</button>
            <!-- <button type="button" class="md-btn md-btn-wave" onclick="regresar('app/EO/vista/view_enlaces.php');">Regresar</button> -->
            <button type="submit" onclick="formSaveDetallebtn('<?= $nombre ?>','<?= $idPadron; ?>');" class="md-btn md-btn-primary" id="GuardarDetalle" >Guardar</button>
            </form>
        </div>    
    </div>
</div>
<div id="resultados" ></div>
<!-- Modal -->
<!-- ContactosPA(idPa,nomPa) -->
<div class="uk-modal" id="ModalCrearDetalle">
    <div class="uk-modal-dialog" style="top:0px;">
        <div class="uk-overflow-container">
            <div id="ModalCrearDetalleEO">
            </div>
        </div>
    </div>
</div>