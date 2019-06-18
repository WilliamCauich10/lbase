<?php
// session_start();
    include_once('../../../config/database.php');
    $pdo = Database::getInstance()->getPdoObject();

class Dashboard{
	private static $instance = null;

    public function __construct()
    {
        self::getInstance();
    }

    public static function getInstance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Dashboard();
        }

        return self::$instance;
    }
    public function Dashboard1($Id_Enlace){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT
            (SELECT COUNT(*) FROM segmento AS S WHERE S.Id_Enlace = '$Id_Enlace') AS Total_Segmentos,
            (SELECT COUNT(*) FROM padrones AS P INNER JOIN segmento AS S ON S.Id_seg = P.Id_Segmento WHERE S.Id_Enlace = '$Id_Enlace' ) AS Total_Padrones,
            (SELECT COUNT(*) FROM contactos AS C INNER JOIN enlaces_operativos AS E ON C.Id_Enlace = E.Id_Enlace WHERE E.Id_Enlace = '$Id_Enlace' ) AS Total_Contactos,
            (SELECT COUNT(*) FROM contactos AS C INNER JOIN enlaces_operativos AS E ON C.Id_Enlace = E.Id_Enlace WHERE E.Id_Enlace = '$Id_Enlace' AND C.id_cambio = 0 ) AS Contactos_Unicos");
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
                //$fecha = new DateTime($row['fecha']);
                //$fecha = $fecha->format('d-m-Y');
                $rawdata[$i] = $row;
                $dataCat[] = "'" . $row['fecha'] . "'";
                $i++;
            }
    
            return $rawdata;   
            // header('Content-Type: application/json');
            // return $stmt -> fetchAll ( );
            // return $response;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    } 
    public function Dashboard2($iD_Proyecto){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT T1.Id_Enlace,T1.Nombre_Enlace, COUNT(T2.Id_Enlace) AS Unicos FROM enlaces_operativos AS T1
                INNER JOIN contactos AS T2 ON T1.Id_Enlace = T2.Id_Enlace 
                WHERE T2.id_cambio = 0 AND T1.Id_Proyecto = $iD_Proyecto
                GROUP BY T1.Nombre_Enlace");
            $stmt->execute();
            // 
            $stmt2 = $GLOBALS['pdo']->prepare("SELECT T1.Id_Enlace,T1.Nombre_Enlace,COUNT(T2.Id_Enlace) AS TOTAL FROM enlaces_operativos AS T1
                INNER JOIN contactos AS T2 ON T1.Id_Enlace = T2.Id_Enlace 
                WHERE T1.Id_Proyecto = $iD_Proyecto
                GROUP BY T1.Nombre_Enlace;");
            $stmt2->execute();
            $stmt3 = $GLOBALS['pdo']->prepare("SELECT  T1.Id_Enlace,T1.Nombre_Enlace, COUNT(T2.Id_Enlace) AS Tot_Padron FROM enlaces_operativos AS T1
                left JOIN padrones AS T2 ON T1.Id_Enlace = T2.Id_Enlace
                WHERE T1.Id_Proyecto = $iD_Proyecto
                GROUP BY T1.Nombre_Enlace;");
            $stmt3->execute();
            // 
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // $response .= $row;
                $response []= array(
                    'Id_Enlace' => $row['Id_Enlace'],
                    'Nombre_Enlace' => $row['Nombre_Enlace'],
                    'Unicos' => $row['Unicos'],
                    // 'TOTAL' => lista($row['Id_Enlace']);
                );                                 
            }
            $i=0;
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                if ( $response[$i]['Id_Enlace'] == $row2['Id_Enlace']) {
                    $response[$i]['TOTAL'] = $row2['TOTAL'];
                }
                $i++;
            }
            $a=0;
            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
                if ( $response[$a]['Id_Enlace'] == $row3['Id_Enlace']) {
                    $response[$a]['Tot_Padron'] = $row3['Tot_Padron'];
                }
                $a++;
            }
            $options = '<thead>
                <tr>
                    <th style="width: 30%">Segmento</th>
                    <th style="width: 25%; text-align: center">Padrones</th>
                    <th style="width: 25%; text-align: center">Total usuarios</th>
                    <th style="width: 20%; text-align: center">Total usuarios unicos</th>
                </tr>
            </thead>
            <tbody>';
            $total = sizeof($response); 
            for ($i=0; $i < $total; $i++) { 
                $options .= '<tr>
                <td> ' . $response[$i]['Nombre_Enlace'] . '</td> 
                <td style="text-align: center">' . $response[$i]['Tot_Padron'] . '</td>
                <td style="text-align: center">' . $response[$i]['TOTAL'] . '</td>
                <td style="text-align: center">' .$response[$i]['Unicos'] . '</td>
             </tr>';
            }
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
    function lista($ID){
        $stmt2 = $GLOBALS['pdo']->prepare("SELECT COUNT(T2.Id_Enlace) AS TOTAL FROM  contactos AS T2 
        WHERE T2.Id_Enlace = $ID");
        $stmt2->execute();
        return $stmt2;
    }
    
}
?>