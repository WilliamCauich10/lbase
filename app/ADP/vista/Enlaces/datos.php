<?php 
// for ($i = 0; $i < count($datos); $i++) {
//     $Total_Segmentos = $datos[$i]['Total_Segmentos'];
//     $Total_Padrones = $datos[$i]['Total_Padrones'];
//     $Total_Contactos = $datos[$i]['Total_Contactos'];
//     $Contactos_Unicos = $datos[$i]['Contactos_Unicos'];
// }
// $datos[0]['Total_Padrones'] + $datos[0]['Total_Contactos']
?>

<div>
        <div class="md-card">
            <div class="md-card-content">
            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                <span class="uk-text-muted uk-text-small">Total Segmentos</span>
                <h2 class="uk-margin-remove" id="peity_live_text"><?= $datos[0]['Total_Segmentos']; ?></h2>
            </div>
        </div>
    </div>
    <!--  -->
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <span class="uk-text-muted uk-text-small">Total Padrones</span>
                <h2 class="uk-margin-remove" id="peity_live_text"><?= $datos[0]['Total_Padrones']; ?></h2>
            </div>
        </div>
    </div>
    <!--  -->
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <span class="uk-text-muted uk-text-small">Contactos Asignados</span>
                <h2 class="uk-margin-remove" id="peity_live_text"><?php echo  $datos[0]['Total_Contactos']; ?> </h2>
            </div>
        </div>
    </div>
    <!--  -->
    <div>
        <div class="md-card">
            <div class="md-card-content">
                <span class="uk-text-muted uk-text-small">Total Contactos unicos</span>
                <h2 class="uk-margin-remove" id="peity_live_text"><?= $datos[0]['Contactos_Unicos']; ?></h2>
            </div>
        </div>
    </div>