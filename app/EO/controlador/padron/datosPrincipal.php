<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$id_enlace = $_SESSION['Id_EnlaceOP'];

$SEGMENTO = $pdo -> prepare("SELECT S.Id_seg FROM segmento AS S WHERE S.Id_Enlace = '$id_enlace'");
$execute2 = $SEGMENTO -> execute();
$idS="";
while( $row2 = $SEGMENTO -> fetch()){    
    $idS .= $row2['Id_seg'].',';
}
$id_Segmento = substr($idS, 0, -1);
$Results = $pdo -> prepare("SELECT
(SELECT COUNT(*) FROM padrones AS P WHERE P.id_Segmento  IN('$id_Segmento')) AS Total_Padron,
(SELECT COUNT(*) FROM segmento AS S WHERE S.Id_Enlace = '$id_enlace' ) AS Total_Segmento,
(SELECT Nombre_Enlace FROM enlaces_operativos WHERE Id_Enlace =  '$id_enlace') AS Nombre_Padron");
$execute = $Results -> execute();
while( $row = $Results -> fetch()){
    $Total_Padron = $row['Total_Padron'];
    $Total_Segmento = $row['Total_Segmento'];
    $Nombre_Padron = $row['Nombre_Padron'];
}
?>

<div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                <span class="uk-text-muted uk-text-small">Nombre del Proyecto</span>
                <h2 class="uk-margin-remove"><?= $Nombre_Padron; ?></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                <span class="uk-text-muted uk-text-small">Segmento</span>
                <h2 class="uk-margin-remove"><?= $Total_Segmento; ?></h2>
            </div>
        </div>
    </div>
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
                <span class="uk-text-muted uk-text-small">Padrones</span>
                <h2 class="uk-margin-remove" id="peity_live_text"><?= $Total_Padron; ?></h2>
            </div>
        </div>
    </div>