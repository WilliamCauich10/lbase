<?php 
session_start();
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
?>

<table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Proyecto</th>
            <th>Responsable</th>
            <th>Usuarios</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
                <?php 
                $id_enlace = $_SESSION['Id_EnlaceOP'];
             $Results = $pdo -> prepare("SELECT T1.*,T2.Nombre_Enlace,T3.Proyecto,T4.Id_Contacto,T4.Nombre,T4.Ape_Pat, T4.id_cambio, COUNT(T5.Id_Padron) AS Total FROM padrones AS T1
             INNER JOIN enlaces_operativos AS T2 ON T1.Id_Enlace = T2.Id_Enlace
             INNER JOIN proyecto AS T3 ON T2.Id_Proyecto = T3.Id_Proyecto
             INNER JOIN contactos AS T4 ON T1.Id_Persona = T4.Id_Contacto
			LEFT JOIN detalle_padron AS T5 ON T1.Id_Padron = T5.Id_Padron	
            WHERE T1.Id_Enlace = '$id_enlace'	
				 GROUP BY T1.Id_Padron");
             $execute = $Results -> execute();
             while( $row = $Results -> fetch()){
            ?>
            <tr onclick="ContactosPA('<?= $row['Id_Padron'] ?>','<?= $row['Nom_Padron'] ?>')">
            <td >
                <?= $row['Nom_Padron'] ?>
            </td>
            <td>
                <?= $row['Proyecto'] ?>
            </td>
            <td>
                <?= $row['Nombre'] ?> 
                <?= $row['Ape_Pat'] ?>
            </td>
            <td style="text-align: center;">                     
                <span class="uk-badge"><?= $row['Total'] ?></span>
            </td>
            <td>
            <!-- <a href="#ModalEnlaces" data-uk-modal="{ center:true }" onclick="modal_EnlacesAP(<?= $row['Id_Padron']; ?>,'Editar_Contactos_Padrones')"><i class="md-icon material-icons">&#xE254;</i></a> -->
            <a onclick="UIkit.modal.confirm('Estas seguro que desea borrarlo?', function(){ borrarPadron('<?= $row['Id_Padron']; ?>','<?= $row['Id_Persona'] ?>', '<?= $row['id_cambio'] ?>') });"><i class="md-icon material-icons">&#xE872;</i></a>
            </td>
            </tr>
        <?php 
            }
        ?>
    </tbody>               
</table>