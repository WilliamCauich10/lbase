<!-- Este es para la tabla de resultados de la busqueda de usuarios-->
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
$idPadron = isset($_POST["idPadron"]) ? $_POST["idPadron"] : "";
$apellidomAT = isset($_POST["apellidoMat"]) ? $_POST["apellidoMat"] : "";
// $Results2 = $pdo -> prepare("SELECT * FROM padrones WHERE padrones.Id_Padron = '$idPadron'");
// $execute = $Results2 -> execute();
// while( $row2 = $Results2 -> fetch()){
//     $nombrePadron =$row2['Nom_Padron'];
// }
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
                    <a class="uk-icon-hover uk-icon-plus-circle" onclick ="createEO()"> Agregar</a>
                        
                    </div>
                </th>
            </tr>
        </thead>  
        <tbody>
            <?php 
            $Id_EnlaceOP = $_SESSION['Id_EnlaceOP'];
            if ($nombre !="" && $apellido !="" && $apellidomAT !="") { //todos si
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat  LIKE '%$apellidomAT%' AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido =="" && $apellidomAT =="") { //Solo nombre
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  (T1.Nombre LIKE '%$nombre%') AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            elseif ($apellido !="" && $apellidomAT =="" && $nombre =="") { //Solo Apellido paterno
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  (T1.Ape_Pat LIKE '%$apellido%') AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            elseif ($apellidomAT !="" && $apellido =="" && $nombre =="") { //Solo Apellido materno
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  (T1.APe_Mat LIKE '%$apellidomAT%') AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido !="" && $apellidomAT =="") { // nom y app
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%' AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido =="" && $apellidomAT !="") { // nom y apm
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Nombre LIKE '%$nombre%' AND T1.APe_Mat LIKE '%$apellidomAT%' AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            elseif ($nombre =="" && $apellido !="" && $apellidomAT !="") { // app y apm
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >3 AND  T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat LIKE '%$apellidomAT%' AND T1.Id_Enlace = $Id_EnlaceOP");
                $execute = $Results -> execute();
            }
            //  $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
            //  WHERE T1.id_cambio ='0'  AND T1.Id_perfil >3 AND (T1.Nombre LIKE '%$nombre%' OR T1.Ape_Pat LIKE '%$apellido%' )");
            //  $execute = $Results -> execute();
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
                    <a class="uk-icon-hover uk-icon-check" onclick="UserSelect('<?= $row['Id_Contacto'] ?>','<?= $idPadron; ?>',)"></a>
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
    <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
</div>