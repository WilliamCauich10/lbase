<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$idPadron = isset($_POST['id']) ? $_POST['id'] : "";
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : "";
?>

<div class="md-card">
    <div class="md-card-toolbar">   
        <div class="md-card-toolbar-actions">
            <a  class="md-btn md-btn-small md-btn-flat md-btn-flat-primary"  onclick=" CrearDetalle(<?= $idPadron; ?>,'<?= $nombre; ?>','DetalleBL')">Agregar</a>
        </div>          
        <h3 class="md-card-toolbar-heading-text">
            <?= $nombre; ?>
        </h3>
    </div>
    <div class="md-card-content">
        <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
            <thead>                        
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
             $Results = $pdo -> prepare("SELECT T2.* FROM detalle_padron AS T1
             INNER JOIN contactos AS T2 ON T1.Id_Contacto = T2.Id_Contacto WHERE T1.Id_Padron='$idPadron'");
             $execute = $Results -> execute();
             while( $row = $Results -> fetch()){
            ?>
             <tr>
                <td >
                    <?= $row['Nombre'] ?>
                </td>
                <td>
                    <?= $row['Ape_Pat'] ?>
                </td>
                <td>
                    <?= $row['Correo'] ?>
                </td>
                <td>
                    <?= $row['Telefono'] ?> 
                </td>
                <td>
                
                <a onclick="UIkit.modal.confirm('Estas seguro que desea borrarlo?', function(){ borrarUserDetallePadron('<?= $row['Id_Contacto']; ?>','<?= $idPadron ?>','<?= $nombre ?>','<?= $row['id_cambio'] ?>') });"><i class="md-icon material-icons">&#xE872;</i></a>
                </td>
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