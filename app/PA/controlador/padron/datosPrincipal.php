<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$id_Segmento = $_SESSION['Id_Segmento'];//Segmento
$id_Enlace = $_SESSION['Id_EnlaceOP'];
$Results = $pdo -> prepare("SELECT
(SELECT COUNT(*) FROM padrones WHERE Id_Segmento = $id_Segmento) AS Total_Padron, 
(SELECT COUNT(*) FROM detalle_padron INNER JOIN padrones AS T2 ON detalle_padron.Id_Padron = T2.Id_Padron ) AS Total_Usuario,
(SELECT S.Nombre_Seg FROM segmento AS S WHERE S.Id_seg = $id_Segmento) AS Nombre_Segmento");
$execute = $Results -> execute();
while( $row = $Results -> fetch()){
    $Total_Padron = $row['Total_Padron'];
    $Total_Usuario = $row['Total_Usuario'];
    $Nombre_Segmento = $row['Nombre_Segmento'];
}
?>

<div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                <span class="uk-text-muted uk-text-small">Nombre del enlace </span>
                <h2 class="uk-margin-remove"><?= $Nombre_Segmento; ?></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                <span class="uk-text-muted uk-text-small">Padrones</span>
                <h2 class="uk-margin-remove"><?= $Total_Padron; ?></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
                <span class="uk-text-muted uk-text-small">Usuarios</span>
                <h2 class="uk-margin-remove" id="peity_live_text"><?= $Total_Usuario; ?></h2>
            </div>
        </div>
    </div>