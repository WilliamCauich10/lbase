<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
?>
<div class="uk-grid uk-grid-width-large-1-3 " data-uk-sortable data-uk-grid-margin id="Pdatos" >
</div>

<div class="uk-grid uk-grid-width-medium-1-2" data-uk-grid-margin>
    <div class="md-card">
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
                <a  class="md-btn md-btn-small md-btn-flat md-btn-flat-primary"  onclick="CrearPadrones('4','PadronBL')">Agregar</a>
            </div>
            <h3 class="md-card-toolbar-heading-text">
                Segmento
            </h3>
        </div>
        <div class="md-card-content" id="TablaPadron">
            <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <!-- <th>Proyecto</th> -->
                        <th>Responsable</th>
                        <th>Padrones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $id_enlace = $_SESSION['Id_EnlaceOP'];
             $Results = $pdo -> prepare("SELECT S.*, E.Nombre_Enlace, P.Proyecto, C.Id_Contacto, C.Nombre, C.Ape_Pat, C.id_cambio, COUNT(PA.Id_Segmento) AS Total
             FROM segmento AS S
             INNER JOIN enlaces_operativos AS E ON S.Id_Enlace = E.Id_Enlace
             INNER JOIN proyecto AS P ON E.Id_Proyecto = P.Id_Proyecto
             INNER JOIN contactos AS C ON S.Id_Persona = C.Id_Contacto
             LEFT JOIN padrones AS PA ON S.Id_seg = PA.Id_Segmento
             WHERE S.Id_Enlace = '$id_enlace'
             GROUP BY S.Id_seg");
             $execute = $Results -> execute();
             while( $row = $Results -> fetch()){
            ?>
             <tr onclick="ContactosPA('<?= $row['Id_seg'] ?>','<?= $row['Nombre_Seg'] ?>')">
                <td >
                    <?= $row['Nombre_Seg'] ?>
                </td>
                <!-- <td> -->
                    
                <!-- </td> -->
                <td>
                    <?= $row['Nombre'] ?> 
                    <?= $row['Ape_Pat'] ?>
                </td>
                <td style="text-align: center;">                     
                    <span class="uk-badge"><?= $row['Total'] ?></span>
                </td>
                <td>
                <!-- <a href="#ModalEnlaces" data-uk-modal="{ center:true }" onclick="modal_EnlacesAP(<?= $row['Id_seg']; ?>,'Editar_Contactos_Padrones')"><i class="md-icon material-icons">&#xE254;</i></a> -->
                <a onclick="UIkit.modal.confirm('Estas seguro que desea borrarlo?', function(){ borrarPadron('<?= $row['Id_seg']; ?>','<?= $row['Id_Persona'] ?>', '<?= $row['id_cambio'] ?>') });"><i class="md-icon material-icons">&#xE872;</i></a>
                </td>
             </tr>
            <?php 
             }
            ?>
                </tbody>               
            </table>
            <!-- conntenido -->
        </div>
    </div> <!-- Card -->
    <!-- Div para mostrar los contactos por padrones -->
    <div id="Contactos_Tabla_PA" >       
    </div>
</div> <!-- fin -->
<div id="resultados" ></div>
<!-- Modal -->
<div class="uk-modal" id="ModalEnlaces">
    <div class="uk-modal-dialog" style="top:0px;">
        <div class="uk-overflow-container">
            <div id="ModalEO">
            </div>
        </div>
    </div>
</div>

<!--  -->
<script>
    principalDatos();
      function ContactosPA(id,nombre){
        // document.getElementById('Contactos_Tabla_PA').style.display = 'block';
        $("#Contactos_Tabla_PA").load("app/EO/vista/view_contactos.php",{id: id,nombre:nombre});
        // 
        $('body, html').animate({
			scrollTop: '0px'
		}, 300);
    }
</script>
