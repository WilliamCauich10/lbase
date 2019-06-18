<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
$apellidomAT = isset($_POST["apellidoMat"]) ? $_POST["apellidoMat"] : "";
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
                        <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav">
                                <li>
                                <a class="uk-icon-hover uk-icon-plus-circle" onclick ="createOpt()"> Agregar</a>
                                </li>
                                <!-- <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>
                                <li><a href="#"><i class="material-icons">&#xE872;</i> Delete</a></li> -->
                            </ul>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>  
        <tbody>
            <?php 
            $Id_Proyecto = $_SESSION['id_proyecto'];
            // $ResultsIDenlace = $pdo -> prepare("SELECT * FROM contactos AS T1 
            //     WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat  LIKE '%$apellidomAT%'");
            //     $execute = $ResultsIDenlace -> execute();
                // 

               if ($nombre !="" && $apellido !="" && $apellidomAT !="") { //todos si
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat  LIKE '%$apellidomAT%'");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido =="" && $apellidomAT =="") { //Solo nombre
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  (T1.Nombre LIKE '%$nombre%')");
                $execute = $Results -> execute();
            }
            elseif ($apellido !="" && $apellidomAT =="" && $nombre =="") { //Solo Apellido paterno
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  (T1.Ape_Pat LIKE '%$apellido%')");
                $execute = $Results -> execute();
            }
            elseif ($apellidomAT !="" && $apellido =="" && $nombre =="") { //Solo Apellido materno
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  (T1.APe_Mat LIKE '%$apellidomAT%')");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido !="" && $apellidomAT =="") { // nom y app
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%$nombre%' AND T1.Ape_Pat LIKE '%$apellido%'");
                $execute = $Results -> execute();
            }
            elseif ($nombre !="" && $apellido =="" && $apellidomAT !="") { // nom y apm
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%$nombre%' AND T1.APe_Mat LIKE '%$apellidomAT%'");
                $execute = $Results -> execute();
            }
            elseif ($nombre =="" && $apellido !="" && $apellidomAT !="") { // app y apm
                $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
                WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Ape_Pat LIKE '%$apellido%' AND T1.APe_Mat LIKE '%$apellidomAT%'");
                $execute = $Results -> execute();
            }
            //  $Results = $pdo -> prepare("SELECT * FROM contactos AS T1 
            //  WHERE T1.Nombre LIKE '%$nombre%' OR T1.Ape_Pat LIKE '%$apellido%' AND T1.id_cambio ='0'");
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
                    <a class="uk-icon-hover uk-icon-check" onclick="UserSelectADP('<?= $row['Id_Contacto'] ?>')"></a>
                </td>
            </tr>
            <?php 
             }
            ?>
        </tbody>                         
    </table>
    <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
</div>