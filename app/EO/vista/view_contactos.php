<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$idSegmento = isset($_POST['id']) ? $_POST['id'] : "";
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
?>

<div class="md-card">
    <div class="md-card-toolbar">   
        <div class="md-card-toolbar-actions">
            <!-- <a  class="md-btn md-btn-small md-btn-flat md-btn-flat-primary"  onclick=" CrearDetalle(<?= $idSegmento; ?>,'<?= $nombre; ?>','DetalleBL')">Agregar</a> -->
        </div>          
        <h3 class="md-card-toolbar-heading-text">
            <?= $nombre; ?>
        </h3>
    </div>
    <div class="md-card-content">
        <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
            <thead>                        
                <tr>
                    <th>Nombre </th>
                    <th>Responsable</th>
                    <th>Integrantes</th>
                    <!-- <th>Telefono</th> -->
                    <!-- <th>Acciones</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                
             $Results = $pdo -> prepare("SELECT P.Nom_Padron,C.Nombre,C.Ape_Pat, COUNT(P.Id_Padron)+ COUNT(D.Id_Padron) AS TOTAL FROM padrones AS P
             INNER JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
             LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
             WHERE P.Id_Segmento = '$idSegmento'
             GROUP BY P.Id_Padron");
             $execute = $Results -> execute();
             while( $row = $Results -> fetch()){
            ?>
             <tr>
                <td >
                    <?= $row['Nom_Padron'] ?>
                </td>
                <td>
                    <?= $row['Nombre'] ?> <?= $row['Ape_Pat'] ?>
                </td>
                <td>
                    <?= $row['TOTAL'] ?>
                </td>
                <!-- <td> -->
                
                <!-- <a onclick="UIkit.modal.confirm('Estas seguro que desea borrarlo?', function(){ borrarUserDetallePadron('<?= $row['Id_Contacto']; ?>','<?= $idSegmento ?>','<?= $nombre ?>','<?= $row['id_cambio'] ?>') });"><i class="md-icon material-icons">&#xE872;</i></a> -->
                <!-- </td> -->
             </tr>
            <?php 
             }
            ?>
                </tbody>  
        </table>
    </div>
</div>

<div id="resultadosContactos" ></div>
<!-- Modal -->
<div class="uk-modal" id="ModalContactos">
    <div class="uk-modal-dialog" style="top:0px;">
        <div class="uk-overflow-container">
            <div id="ModalContactosEO">
            </div>
        </div>
    </div>
</div>