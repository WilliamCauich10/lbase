<?php
// session_start();
    include_once('../../../../config/database.php');
    $pdo = Database::getInstance()->getPdoObject();

class Datos{
	private static $instance = null;

    public function __construct()
    {
        self::getInstance();
    }

    public static function getInstance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Datos();
        }

        return self::$instance;
    }
    public function Dashboard1(){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT
            (SELECT COUNT(*) FROM enlaces_operativos) AS Total_Segmentos,
            (SELECT COUNT(*) FROM padrones) AS Total_Padrones,
            (SELECT COUNT(*) FROM contactos AS T4 INNER JOIN enlaces_operativos AS T5 ON T5.Id_Enlace = T4.Id_Enlace) AS Total_Contactos,
            (SELECT COUNT(*) FROM contactos AS T4 INNER JOIN enlaces_operativos AS T5 ON T5.Id_Enlace = T4.Id_Enlace WHERE T4.id_cambio = 0 ) AS Contactos_Unicos");
            $stmt->execute();
            
            header('Content-Type: application/json');
            return $stmt -> fetchAll ( );
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }   
    public function lienaRegistro(){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT DATE_FORMAT( T1.Fecha, '%d-%m-%Y' ) AS fecha, COUNT(*) AS totalPlantilla, SUM(T1.Id_Persona) AS totalMilitantes FROM padrones AS T1");
            $stmt->execute();
            $rawdata = Array();
            $i = 0;
            $dataCat = Array();
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rawdata[$i] = $row;
                $dataCat[] = "'" . $row['fecha'] . "'";
                $i++;
            }
    
            return $rawdata;   
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    } 
    public function busqueda($nombre,$apellido,$apellidomAT,$Id_EnlaceOP,$var,$idPadron){
        try{
            $SQL="";
            if ($var ==1) {
                $SQL = "SELECT * FROM contactos AS T1 
                    WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%".$nombre."%' AND T1.Ape_Pat LIKE '%".$apellido."%' AND T1.APe_Mat  LIKE '%".$apellidomAT."%' AND T1.Id_Enlace = ".$Id_EnlaceOP;
                // $stmt->execute();
            }
            if ($var ==2) {
                $SQL = "SELECT * FROM contactos AS T1 WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  (T1.Nombre LIKE '%".$nombre."%') AND T1.Id_Enlace = ".$Id_EnlaceOP;
                // $stmt->execute();
            }
            if ($var ==3) {
                $SQL = "SELECT * FROM contactos AS T1 
                    WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  (T1.Ape_Pat LIKE '%".$apellido."%') AND T1.Id_Enlace = ".$Id_EnlaceOP;
                // $stmt->execute();
            }
            if ($var ==4) {
                $SQL = "SELECT * FROM contactos AS T1 
                    WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%".$nombre."%' AND T1.Ape_Pat LIKE '%".$apellido."%' AND T1.Id_Enlace = ".$Id_EnlaceOP;
                // $stmt->execute();   
            }
            if ($var ==5) {
                $SQL = "SELECT * FROM contactos AS T1 
                    WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Nombre LIKE '%".$nombre."%' AND T1.APe_Mat LIKE '%".$apellidomAT."%' AND T1.Id_Enlace = ".$Id_EnlaceOP;
                // $stmt->execute();
            }
            if ($var ==6) {
                $SQL = "SELECT * FROM contactos AS T1 
                    WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  T1.Ape_Pat LIKE '%".$apellido."%' AND T1.APe_Mat LIKE '%".$apellidomAT."%' AND T1.Id_Enlace = ".$Id_EnlaceOP;
                // $stmt->execute();
            }
            if ($var ==7) {
                $SQL = "SELECT * FROM contactos AS T1 
                    WHERE T1.id_cambio ='0'  AND T1.Id_perfil >2 AND (T1.Nombre LIKE '%".$nombre."%' OR T1.Ape_Pat LIKE '%".$apellido."%' )";
                // $stmt->execute();
            }
            $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM contactos AS T1 WHERE T1.id_cambio ='0' AND T1.Id_perfil >2 AND  (T1.Nombre LIKE '%$nombre%') AND T1.Id_Enlace = $Id_EnlaceOP");
            $stmt->execute();
            $stmt2 = $GLOBALS['pdo']->prepare("SELECT * FROM padrones WHERE padrones.Id_Padron = '$idPadron'");
            $stmt2->execute();
            $nombrePadron="";
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                $nombrePadron = $row2['Nom_Padron'];                                      
            }
            // 
            $options = '
            <div class="md-card-content" style="width:94%">
    <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>
                    <div class="md-card-list-item-menu" data-uk-dropdown="{mode:"click",pos:"right-top"}">
                        <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav">
                                <li>
                                <a class="uk-icon-hover uk-icon-plus-circle" onclick ="createEO(\'0\',\' '. $idPadron .'\',\' '.$nombrePadron .'\')"> Agregar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>  
            ';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $options .=  '
                <tr>
                <td>
                    '.$row['Nombre'] .'
                </td>
                <td>
                    '. $row['Ape_Pat'] .'
                </td>
                <td>
                    '. $row['APe_Mat'] .'
                </td>
                <td>
                    '. $row['Correo'] .'
                </td>
                <td>
                    <a class="uk-icon-hover uk-icon-check" onclick="UserSelect(\''. $row['Id_Contacto'] .' \',\' '.$idPadron .'\',\' '. $nombrePadron.' \')"></a>
                </td>
            </tr>
                ';
            }
            $options .='
                </tbody>                         
            </table>
                <button type="button" class="md-btn md-btn-flat uk-modal-close" >Close</button>
            </div>
            ';
            $response2 = array(
                'success' => TRUE,
                'options' => $options
            );

            header('Content-Type: application/json');
            return $response2;
            // return $stmt -> fetchAll ( );
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    } 
    
}
?>