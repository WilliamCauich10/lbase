<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
$apellidomAT = isset($_POST["apellidoMat"]) ? $_POST["apellidoMat"] : "";

$id_enlace = $_SESSION['Id_EnlaceOP'];
?>

<div class="md-card-content" style="width:94%">
    <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>
                    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'right-top'}">
                    <a class="uk-icon-hover uk-icon-plus-circle" onclick ="createPA()"> Agregar</a>
                        
                    </div>
                </th>
            </tr>
        </thead>  
        <tbody>
            <?php 
             $Id_Proyecto = $_SESSION['id_proyecto'];
            $Id_EnlaceOP = $_SESSION['Id_EnlaceOP'];
            if ($nombre !="" && $apellido !="" && $apellidomAT !="") { //todos si
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat  LIKE '%$apellidomAT%' AND T1.Id_Proyecto = $Id_Proyecto");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido =="" && $apellidomAT =="") { //Solo nombre
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  (T1.Nombre LIKE '%$nombre%') AND  T1.Id_Proyecto = $Id_Proyecto");
                $execute = $Results -> execute();
            }
            elseif ($apellido !="" && $apellidomAT =="" && $nombre =="") { //Solo Apellido paterno
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  (T1.Ape_Pat LIKE '%$apellido%') AND T1.Id_Proyecto = $Id_Proyecto");
                $execute = $Results -> execute();
            }
            elseif ($apellidomAT !="" && $apellido =="" && $nombre =="") { //Solo Apellido materno
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  (T1.APe_Mat LIKE '%$apellidomAT%') AND T1.Id_Proyecto = $Id_Proyecto");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido !="" && $apellidomAT =="") { // nom y app
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%' AND T1.Id_Proyecto =  $Id_Proyecto");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido =="" && $apellidomAT !="") { // nom y apm
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Nombre LIKE '%$nombre%' AND T1.APe_Mat LIKE '%$apellidomAT%' AND T1.Id_Proyecto = $Id_Proyecto");
                $execute = $Results -> execute();
            }
            elseif ($nombre =="" && $apellido !="" && $apellidomAT !="") { // app y apm
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat LIKE '%$apellidomAT%' AND T1.Id_Proyecto = $Id_Proyecto");
                $execute = $Results -> execute();
            }
             while( $row = $Results -> fetch()){
            ?>
            <tr>
                <td>
                    <?= $row['Nombre'] ?>
                </td>
                <td>
                    <?= $row['Ape_Pat'] ?>
                </td>
                <td>
                    <?= $row['APe_Mat'] ?>
                </td>
                <td>
                    <?= $row['Correo'] ?>
                </td>
                <td>
                    <a class="uk-icon-hover uk-icon-check" onclick="UserSelect_PA('<?= $row['Id_Contacto'] ?>','<?= $id_enlace ?>')"></a>
                </td>
            </tr>
            <?php 
             }
             if ($Results -> rowCount() > 0 ) {}else{ ?>
             <tr>
                <td colspan =5>
                   No se encontraron datos
                </td>
             </tr>
            <?php
             }
            ?>
        </tbody>                         
    </table>
    <button type="button" class="md-btn md-btn-flat uk-modal-close" id="closeModalPA" >Close</button>
</div>