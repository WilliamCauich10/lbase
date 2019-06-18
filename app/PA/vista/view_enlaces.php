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
                Padrones
            </h3>
        </div>
        <div class="md-card-content" id="TablaPadron">
            <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <!-- <th>Proyecto</th> -->
                        <th>Responsable</th>
                        <th>Usuarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $id_enlace = $_SESSION['Id_Segmento'];
             $Results = $pdo -> prepare("SELECT T1.*,T2.Nombre_Seg,T4.Id_Proyecto,T4.Id_Contacto,T4.Nombre,T4.Ape_Pat, T4.id_cambio, COUNT(T5.Id_Padron) AS Total 
             FROM padrones AS T1
             INNER JOIN segmento AS T2 ON T1.Id_Segmento = T2.Id_seg
             INNER JOIN contactos AS T4 ON T1.Id_Persona = T4.Id_Contacto
             LEFT JOIN detalle_padron AS T5 ON T1.Id_Padron = T5.Id_Padron		
             WHERE T1.Id_Segmento = '$id_enlace'
             GROUP BY T1.Id_Padron");
             $execute = $Results -> execute();
             while( $row = $Results -> fetch()){
            ?>
             <tr onclick="ContactosPA('<?= $row['Id_Padron'] ?>','<?= $row['Nom_Padron'] ?>')">
                <td >
                    <?= $row['Nom_Padron'] ?>
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
                <!-- <a href="#ModalEnlaces" data-uk-modal="{ center:true }" onclick="modal_EnlacesAP(<?= $row['Id_Padron']; ?>,'Editar_Contactos_Padrones')"><i class="md-icon material-icons">&#xE254;</i></a> -->
                <a onclick="UIkit.modal.confirm('Estas seguro que desea borrarlo?', function(){ borrarPadron('<?= $row['Id_Padron']; ?>','<?= $row['Id_Persona'] ?>', '<?= $row['id_cambio'] ?>') });"><i class="md-icon material-icons">&#xE872;</i></a>
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
    // alert(id_P);
    if (id_P != 0) {
        ContactosPA(id_P,Nm_P)
        
    }
      function ContactosPA(id,nombre){
        id_P= id;Nm_P = nombre;
        // document.getElementById('Contactos_Tabla_PA').style.display = 'block';
        $("#Contactos_Tabla_PA").load("app/PA/vista/view_contactos.php",{id: id,nombre:nombre});
        // 
        $('body, html').animate({
			scrollTop: '0px'
		}, 300);
    }
</script>