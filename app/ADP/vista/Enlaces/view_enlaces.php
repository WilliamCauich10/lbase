<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
?>
<div class="uk-grid uk-grid-width-medium-1-1" data-uk-grid-margin>
    <div class="md-card">
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
                <a  class="md-btn md-btn-small md-btn-flat md-btn-flat-primary"  href="#ModalEnlacesOperativos" data-uk-modal="{ center:true }" onclick=" modal_EnlacesOpe('1','Busq_Crear')">Agregar</a>
            </div>
            <h3 class="md-card-toolbar-heading-text">
                Enlaces Operativos
            </h3>
        </div>
        <div class="md-card-content">
            <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Proyecto</th>
                        <th>Responsable</th>
                        <th>Proyecto Master</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
             $Results = $pdo -> prepare("SELECT * FROM enlaces_operativos AS T1
             INNER JOIN proyecto AS T2 USING (Id_Proyecto)
             INNER JOIN contactos AS T3 USING (Id_Contacto)");
             $execute = $Results -> execute();
             while( $row = $Results -> fetch()){
            ?>
             <tr>
                <td >
                    <?= $row['Nombre_Enlace'] ?>
                </td>
                <td>
                    <?= $row['Nombre'] ?> 
                    <?= $row['Ape_Pat'] ?>
                </td>
                <td>
                    <?= $row['Proyecto'] ?>
                </td>
                <td>
                    <?= $row['Correo'] ?>
                </td>
                <td>
                <!-- <a href="#ModalEnlaces" data-uk-modal="{ center:true }" onclick="modal_EnlacesAP(<?= $row['Id_Padron']; ?>,'Editar_Contactos_Padrones')"><i class="md-icon material-icons">&#xE254;</i></a> -->
                <a onclick="borrarEnlace(<?= $row['Id_Enlace']; ?>)"><i class="md-icon material-icons">&#xE872;</i></a>
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
    <div id="Recolestores_tabla" style='display:none;'>
       
    </div>
</div> <!-- fin -->
<div id="resultados" ></div>
<!-- Modal -->
<div class="uk-modal" id="ModalEnlacesOperativos">
    <div class="uk-modal-dialog" style="top:0px;">
        <div class="uk-overflow-container">
            <div id="ModalOp">
            </div>
        </div>
    </div>
</div>

<!--  -->
<script>
    //   function Recolectores(id,nombre){
    //     document.getElementById('Recolestores_tabla').style.display = 'block';
    //     $("#Recolestores_tabla").load("AdminProyect/vistas/Recolectores.php",{id: id,nombre:nombre});
    //     // 
    //     $('body, html').animate({
	// 		scrollTop: '0px'
	// 	}, 300);
    // }
</script>