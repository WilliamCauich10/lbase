<?php 
session_start();
if(!isset($_SESSION['id_usuario'])){
    header("Location: index.php");
    exit();
}
include_once('../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();

?>

<div class="uk-grid uk-grid-width-large-1-3 " data-uk-sortable data-uk-grid-margin id="Pdatos" >
    
</div>
    <div class="uk-grid">
        <div class="uk-width-1-1">
            <div class="md-card">
                <div class="md-card-toolbar">
                    <div class="md-card-toolbar-actions">
                        <!--<i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                        <i class="md-icon material-icons">&#xE5D5;</i>-->
                        <!--<div class="md-card-dropdown" data-uk-dropdown="{pos:'bottom-right'}">
                            <i class="md-icon material-icons">&#xE5D4;</i>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav">
                                    <li><a href="#">Action 1</a></li>
                                    <li><a href="#">Action 2</a></li>
                                </ul>
                            </div>
                        </div>-->
                    </div>
                    <h3 class="md-card-toolbar-heading-text">
                        LINEA DE REGISTRO
                    </h3>
                </div>
                <div class="md-card-content">
                    <div class="mGraph-wrapper">
                        <div id="graphLinea" class="mGraph" data-uk-check-display></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<!-- Total de integrantes -->
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
            </div>
            <h3 class="md-card-toolbar-heading-text">
                TOTAL DE INTEGRANTES POR SINDICATO
            </h3>
        </div>
        <div class="md-card-content">
        <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-10-10">
                        <form action="app/ADP/vista/exportar/exportar2.php" method="post" target="_blank" id="FormularioExportacionSindicatos">
                            <input id="exportarSindicatos" type="submit" class="md-btn md-btn-warning" style="float: right;" value="Exportar">
                            <input type="hidden" id="tabla_municipios" name="tabla_municipios" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-10-10">
                        <div class="uk-overflow-container">
                            <table id="tblSindicatos" class="uk-table">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-toolbar">
            <div class="md-card-toolbar-actions">
            </div>
            <h3 class="md-card-toolbar-heading-text">
                DISPERSIÓN ELECTORAL Y SOCIODEMOGRÁFICA POR SINDICATO
            </h3>
        </div>
        <div class="md-card-content">
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-3-10">
                        <label>Sindicato</label>
                        <select id="select_sindicato" name="select_sindicato" class="select" data-md-selectize data-md-selectize-bottom onchange="obtenerTablaSecciones(this.value);">
                            <option value="0">TODOS</option>
                            <?php
                            $sql = "SELECT P.Id_Padron, P.Nom_Padron FROM padrones P 
                            WHERE P.Id_Segmento = :idSegmento";
                            $stmt = $GLOBALS['pdo']->prepare($sql);
                            $stmt->bindValue(':idSegmento', $_SESSION['Id_Segmento']);
                            $stmt->execute();

                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($rows as $row)
                            {
                                ?>
                                <option value="<?=$row['Id_Padron']?>"><?=$row['Nom_Padron']?></option>';
                                <?php
                            }
                            ?>
                        </select>
                        <input type="hidden" id="nombre_sindicato">
                    </div>
                    <div class="uk-width-medium-7-10">
                        <form action="app/exportar/exportar.php" method="post" target="_blank" id="FormularioExportacion">
                            <input id="exportarSecciones" type="submit" class="md-btn md-btn-warning" style="float: right;" value="Exportar">
                            <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-overflow-container">
                    <table id="tblSecciones" class="uk-table uk-table-hover">

                    </table>

                </div>
            </div>
         

        </div>
    </div>

    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-3-10">
                        <label>Distrito Local</label>
                        <select id="select_distrito" name="select_distrito" class="select" data-md-selectize data-md-selectize-bottom onchange="crearGraficaSindicatos(this.value); obtenerTablaGraficaSindicatos(this.value);" >
                            <option value="">Seleccione el distrito</option>
                            <?php
                            $sql = "SELECT DISTRITO_L
                                    FROM secciones
                                    GROUP BY DISTRITO_L";
                            $stmt = $GLOBALS['pdo']->prepare($sql);
                            $stmt->execute();

                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($rows as $row)
                            {
                                ?>
                                <option value="<?=$row['DISTRITO_L']?>"><?=$row['DISTRITO_L']?></option>';
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="uk-width-medium-5-10">
                        <form action="app\views\exportar3.php" method="post" target="_blank" id="FormularioExportacionDistrito">
                            <input id="exportarSindicatosDistrito" type="button" class="md-btn md-btn-warning" style="float: right;" value="Exportar tabla">
                            <input type="hidden" id="tabla_SindicatosDistrito" name="tabla_SindicatosDistrito" />
                            <input type="hidden" id="distrito_local" name="distrito_local"/>
                        </form>
                    </div>
                    <div class="uk-width-medium-2-10">
                        <form action="app\views\exportar4.php" method="post" target="_blank" id="FormularioExportacionDistritoDetalle">
                            <input type="button" class="md-btn md-btn-warning" style="float: right;" value="Exportar detalle" onclick="exportarDetalle()">
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-5-10">
                        <div id="graficaSindicatos">

                        </div>
                    </div>
                    <div class="uk-width-medium-5-10">
                        <table id="tblGraficaSindicatos" class="uk-table">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-3-10">
                        <label>Municipio</label>
                        <select id="select_municipio" name="select_municipio" class="select" data-md-selectize data-md-selectize-bottom onchange="obtenerTablaGraficaMunicipios(this.value); crearGraficaMunicipios(this.value);">
                            <option value="">Seleccione el municipio</option>
                            <?php
                            $sql = "SELECT id_ine, nom_geo FROM catgeo ORDER BY nom_geo";
                            $stmt = $GLOBALS['pdo']->prepare($sql);
                            $stmt->execute();

                            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($rows as $row)
                            {
                                ?>
                                <option value="<?=$row['id_ine']?>"><?=$row['nom_geo']?></option>';
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="uk-width-medium-5-10">
                        <form action="app\views\exportar4.php" method="post" target="_blank" id="FormularioExportacionMunicipio">
                            <input id="exportarSindicatosMunicipio" type="button" class="md-btn md-btn-warning" style="float: right;" value="Exportar tabla">
                            <input type="hidden" id="tabla_SindicatosMunicipio" name="tabla_SindicatosMunicipio" />
                            <input type="hidden" id="mpio" name="mpio"/>
                        </form>
                    </div>
                    <div class="uk-width-medium-2-10">
                        <input type="button" class="md-btn md-btn-warning" style="float: right;" value="Exportar detalle" onclick="exportarDetalleMunicipio()">
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-5-10">
                        <div id="graficaMunicipios">

                        </div>
                    </div>
                    <div class="uk-width-medium-5-10">
                        <table id="tblGraficaMunicipios" class="uk-table">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>     

<script>
    principaldatosEnlace();  
  id_P = 0;
  Nm_P = '';    
</script>
<!-- <script src="bower_components/peity/jquery.peity.min.js"></script> -->
<!-- page specific plugins -->
    <!-- d3 -->
    <!-- <script src="bower_components/d3/d3.min.js"></script> -->
    <!-- metrics graphics (charts) -->
    <!-- <script src="bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script> -->
    <!-- c3.js (charts) -->
    <!-- <script src="bower_components/c3js-chart/c3.min.js"></script> -->
    <!-- chartist -->
    <!-- <script src="bower_components/chartist/dist/chartist.min.js"></script> -->

    <!--  charts functions -->
    <!-- <script src="assets/js/pages/plugins_charts.min.js"></script> -->
    