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
    public function Dashboard1($ID_Segmento){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT
            (SELECT COUNT(*) FROM padrones AS P WHERE P.Id_Segmento = '$ID_Segmento') AS TotalPadrones,
            (
            (SELECT COUNT(*) FROM padrones AS P WHERE P.Id_Segmento = '$ID_Segmento') +
            (SELECT COUNT(*) FROM padrones AS P
            INNER JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
            INNER JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
            WHERE P.Id_Segmento = '$ID_Segmento')) AS TotalUsuarios,
            (
            (SELECT COUNT(*) FROM contactos AS C LEFT JOIN segmento AS S ON C.Id_Contacto = S.Id_Persona WHERE S.Id_seg = '$ID_Segmento' AND C.id_cambio = 0) +
            (SELECT COUNT(*) FROM padrones AS P LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto WHERE P.Id_Segmento = '$ID_Segmento' AND C.id_cambio = 0)+
            (SELECT COUNT(*) FROM detalle_padron AS D LEFT JOIN padrones AS P ON D.Id_Padron = P.Id_Padron LEFT JOIN contactos AS C ON D.Id_Contacto = C.Id_Contacto WHERE P.Id_Segmento = '$ID_Segmento' AND C.id_cambio = 0 )
            ) AS TotalUnicos            
            ");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {            
                $options ='
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <span class="uk-text-muted uk-text-small">Total Padrones</span>
                            <h2 class="uk-margin-remove" id="peity_live_text">'.$row['TotalPadrones'].'</h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <span class="uk-text-muted uk-text-small">Contactos </span>
                            <h2 class="uk-margin-remove" id="peity_live_text">'.$row['TotalUsuarios'] .' </h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <span class="uk-text-muted uk-text-small">Total Contactos unicos</span>
                            <h2 class="uk-margin-remove" id="peity_live_text">'. $row['TotalUnicos'].'</h2>
                        </div>
                    </div>
                </div>
                ';
            }
            $response2 = array(
                'success' => TRUE,
                'options' => $options
            );

            header('Content-Type: application/json');
            return $response2;
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
    public function Dashboard2($ID_Segmento){
        try{
            $stmt = $GLOBALS['pdo']->prepare("SELECT T1.Id_Padron,T1.Nom_Padron, COUNT(T2.Id_Padron) AS userDetalle FROM padrones AS T1 
            LEFT JOIN detalle_padron AS T2 USING(Id_Padron)
            WHERE T1.Id_Segmento = $ID_Segmento
            GROUP BY T1.Nom_Padron;");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // $response .= $row;
                $response []= array(
                    'Id_Padron' => $row['Id_Padron'],
                    'Nom_Padron' => $row['Nom_Padron'],
                    'userDetalle' => $row['userDetalle'],
                    'TOTAL' => $row['userDetalle']+1
                );                                 
            }
            $options = '<thead>
                <tr>
                    <th style="width: 30%">Enlace</th>
                    <th style="width: 25%; text-align: center">Contactos asignados</th>
                    <th style="width: 20%; text-align: center">Total usuarios</th>
                </tr>
            </thead>
            <tbody>';
            $total = sizeof($response); 
            $TotAsignados=0;
            $TotalUser=0;
            for ($i=0; $i < $total; $i++) { 
                $TotAsignados= $TotAsignados + $response[$i]['userDetalle'];
                $TotalUser= $TotalUser + $response[$i]['TOTAL'];
                $options .= '
            <tr>
                <td> ' . $response[$i]['Nom_Padron'] . '</td> 
                <td style="text-align: center">' . $response[$i]['userDetalle'] . '</td>
                <td style="text-align: center">' .$response[$i]['TOTAL'] . '</td>
             </tr>';
            }
            $options .= ' 
            </tbody>
            <tfoot>           
                <tr>
                    <td>Total</td>
                    <td style="text-align: center">'.$TotAsignados.'</td>
                    <td style="text-align: center">'.$TotalUser.'</td>
                </tr>
                </tfoot>';
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
    public static function GetGraficaSindicatos($distrito){
        try {
            $sql = "SELECT P.Id_Padron,P.Nom_Padron, IFNULL(COUNT(D.Id_Padron),0) AS USUARIOS 
            FROM segmento AS S
            LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
            LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
            LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
            LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
            WHERE P.Id_Segmento = :idSegmento";

            if ($distrito != 0) {
                $sql .= " AND
                            SE.DISTRITO_L = :distrito ";
            }
        
            $sql .= " GROUP BY P.Nom_Padron";

            $stmt = $GLOBALS['pdo']->prepare($sql);
            $stmt->bindValue(':idSegmento', $_SESSION['Id_Segmento']);
            if ($distrito != 0) {
                $stmt->bindValue(':distrito', $distrito);
            }
            $stmt->execute();

            $rawdata = Array();
            $i = 0;
            $dataCat = Array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rawdata[$i] = $row;
                $dataCat[] = "'" . $row['Nom_Padron'] . "'";
                $i++;
            }

            return $rawdata;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }
    public static function GetTablaGraficaSindicatos($distrito){
        // $sql = "SELECT id_sindicato, siglas as sindicato, sum(totalSeccion) as totalSeccion, sum(total) as total 
        //         ";
        $sql = "SELECT P.Id_Padron,P.Nom_Padron, IFNULL(COUNT(D.Id_Padron),0) AS total, count(DISTINCT C.Seccion) as totalSeccion
        FROM segmento AS S
        LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
        LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
        LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
        LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
        WHERE P.Id_Segmento = :SEGMENTO ";

        if ($distrito != 0) {
            $sql .= " AND 
                        SE.DISTRITO_L = :distrito ";
        }

        $sql .= "GROUP BY P.Nom_Padron";

        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->bindValue(':SEGMENTO', $_SESSION['Id_Segmento']);

        if ($distrito != 0) {
            $stmt->bindValue(':distrito', $distrito);
        }

        $stmt->execute();

        $options = '<thead>
                        <tr>
                            <th style="width: 25%; text-align: left">Padron</th>
                            <th style="width: 30%; text-align: center">Secciones</th>
                            <th style="width: 15%; text-align: center">Total Integrantes</th>
                        </tr>
                    </thead>
                    <tbody>';

        $total = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $total = $total + $row['total'];

            $options .= '<tr>
                            <td>' . $row['Nom_Padron'] . '</td> 
                            <td style="text-align: center">' . $row['totalSeccion'] . '</td>
                            <td style="text-align: center">' . $row['total'] . '</td>
                         </tr>';
        }

        $options .= '<tr>
                        <td></td> 
                        <td style="text-align: right">TOTAL: </td>
                        <td style="text-align: center">' . $total . '</td>
                     </tr>';

        $options .= '</tbody>';

        $response = array(
            'success' => TRUE,
            'options' => $options
        );

        header('Content-Type: application/json');
        return $response;
    }
    public static function GetTablaGraficaMunicipios($municipio){
        $sql = "SELECT P.Id_Padron, P.Nom_Padron as Padron, count(DISTINCT C.Seccion) as totalSeccion, IFNULL(COUNT(D.Id_Padron),0) AS total 
        FROM segmento AS S
           LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
           LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
           LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
           LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
          WHERE
               P.Id_Segmento = :idSegmento ";
                    if ($municipio != 0) {
                    $sql .= "   AND
                                SE.MUNICIPIO = :municipio ";
                    }
        $sql .= "GROUP BY P.Nom_Padron   ";

        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->bindValue(':idSegmento', $_SESSION['Id_Segmento']);
        // $stmt->bindValue(':municipio', $municipio);
        if ($municipio != 0) {
            $stmt->bindValue(':municipio', $municipio);
        }
        $stmt->execute();

        $options = '<thead>
                        <tr>
                            <th style="width: 25%; text-align: left">Padron</th>
                            <th style="width: 30%; text-align: center">Secciones</th>
                            <th style="width: 15%; text-align: center">Total Integrantes</th>
                        </tr>
                    </thead>
                    <tbody>';

        $total = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $total = $total + $row['total'];

            $options .= '<tr>
                            <td>' . $row['Padron'] . '</td> 
                            <td style="text-align: center">' . $row['totalSeccion'] . '</td>
                            <td style="text-align: center">' . $row['total'] . '</td>
                         </tr>';
        }

        $options .= '<tr>
                        <td></td> 
                        <td style="text-align: right">TOTAL: </td>
                        <td style="text-align: center">' . $total . '</td>
                     </tr>';

        $options .= '</tbody>';

        $response = array(
            'success' => TRUE,
            'options' => $options
        );

        header('Content-Type: application/json');
        return $response;
    }
    public static function GetGraficaMunicipios($municipio){
        try {
            $sql = "SELECT  P.Id_Padron, P.Nom_Padron as padron, IFNULL(COUNT(D.Id_Padron),0) AS total 
            FROM segmento AS S
                LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
                LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
                LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
                LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
            WHERE P.Id_Segmento =  :idSegmento ";

            if ($municipio != 0) {
                $sql .= " AND
                            SE.MUNICIPIO = :municipio ";
            }

            $sql .= "GROUP BY P.Nom_Padron";

            $stmt = $GLOBALS['pdo']->prepare($sql);
            $stmt->bindValue(':idSegmento', $_SESSION['Id_Segmento']);
            if ($municipio != 0) {
                $stmt->bindValue(':municipio', $municipio);
            }
            $stmt->execute();

            $rawdata = Array();
            $i = 0;
            $dataCat = Array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rawdata[$i] = $row;
                $dataCat[] = "'" . $row['padron'] . "'";
                $i++;
            }

            return $rawdata;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }
    function DispersionDashboard($padron){
        $sql = "SELECT CAT.nom_geo as municipio,P.Id_Padron,P.Nom_Padron, IFNULL(COUNT(D.Id_Padron),0) AS total, COUNT(DISTINCT C.Seccion) as totalSeccion,
        IF( SE.DISTRITO_L = 1, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD1,
        IF( SE.DISTRITO_L = 2, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD2,
        IF( SE.DISTRITO_L = 3, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD3,
        IF( SE.DISTRITO_L = 4, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD4,
        IF( SE.DISTRITO_L = 5, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD5,
        IF( SE.DISTRITO_L = 6, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD6,
        IF( SE.DISTRITO_L = 7, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD7,
        IF( SE.DISTRITO_L = 8, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD8,
        IF( SE.DISTRITO_L = 9, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD9,
        IF( SE.DISTRITO_L = 10, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD10,
        IF( SE.DISTRITO_L = 11, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD11,
        IF( SE.DISTRITO_L = 12, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD12,
        IF( SE.DISTRITO_L = 13, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD13,
        IF( SE.DISTRITO_L = 14, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD14,
        IF( SE.DISTRITO_L = 15, COUNT(DISTINCT C.Seccion), 0 ) AS totalSeccD15,
        IF( SE.DISTRITO_L = 1,COUNT(D.Id_Padron), 0 ) AS totalIntrD1,
        IF( SE.DISTRITO_L = 2,COUNT(D.Id_Padron), 0 ) AS totalIntrD2,
        IF( SE.DISTRITO_L = 3,COUNT(D.Id_Padron), 0 ) AS totalIntrD3,
        IF( SE.DISTRITO_L = 4,COUNT(D.Id_Padron), 0 ) AS totalIntrD4,
        IF( SE.DISTRITO_L = 5,COUNT(D.Id_Padron), 0 ) AS totalIntrD5,
        IF( SE.DISTRITO_L = 6,COUNT(D.Id_Padron), 0 ) AS totalIntrD6,
        IF( SE.DISTRITO_L = 7,COUNT(D.Id_Padron), 0 ) AS totalIntrD7,
        IF( SE.DISTRITO_L = 8,COUNT(D.Id_Padron), 0 ) AS totalIntrD8,
        IF( SE.DISTRITO_L = 9,COUNT(D.Id_Padron), 0 ) AS totalIntrD9,
        IF( SE.DISTRITO_L = 10,COUNT(D.Id_Padron), 0 ) AS totalIntrD10,
        IF( SE.DISTRITO_L = 11,COUNT(D.Id_Padron), 0 ) AS totalIntrD11,
        IF( SE.DISTRITO_L = 12,COUNT(D.Id_Padron), 0 ) AS totalIntrD12,
        IF( SE.DISTRITO_L = 13,COUNT(D.Id_Padron), 0 ) AS totalIntrD13,
        IF( SE.DISTRITO_L = 14,COUNT(D.Id_Padron), 0 ) AS totalIntrD14,
        IF( SE.DISTRITO_L = 15,COUNT(D.Id_Padron), 0 ) AS totalIntrD15
        FROM segmento AS S
        LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
        LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
        LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
        LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
        LEFT JOIN catgeo AS CAT ON SE.MUNICIPIO = CAT.id_ine
        WHERE P.Id_Segmento = :idSegmento ";
        if ($padron != 0){
            $sql .= "AND P.Id_Padron = :padron ";
        }
        $sql .= "GROUP BY CAT.nom_geo;";
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->bindValue(':idSegmento', $_SESSION['Id_Segmento']);

        if ($padron != 0){
            $stmt->bindValue(':padron', $padron);
        }
        $stmt->execute();

        $options = '<thead>
                        <tr>
                        <th></th>';

        $options .= '<th colspan="2" style="text-align: center">DL 1</th>
                    <th colspan="2" style="text-align: center">DL 2</th>
                    <th colspan="2" style="text-align: center">DL 3</th>
                    <th colspan="2" style="text-align: center">DL 4</th>
                    <th colspan="2" style="text-align: center">DL 5</th>
                    <th colspan="2" style="text-align: center">DL 6</th>
                    <th colspan="2" style="text-align: center">DL 7</th>
                    <th colspan="2" style="text-align: center">DL 8</th>
                    <th colspan="2" style="text-align: center">DL 9</th>
                    <th colspan="2" style="text-align: center">DL 10</th>
                    <th colspan="2" style="text-align: center">DL 11</th>
                    <th colspan="2" style="text-align: center">DL 12</th>
                    <th colspan="2" style="text-align: center">DL 13</th>
                    <th colspan="2" style="text-align: center">DL 14</th>
                    <th colspan="2" style="text-align: center">DL 15</th>';

        $options .= '   </tr>
                        <tr>
                        <th>MUNICIPIO</th>';
        for ($r = 0; $r < 15; $r++)
        {
            $options .= '<th style="text-align: center">SEC</th>';
            $options .= '<th style="text-align: center">INT</th>';
        }

        $options .= '<th>TOTAL SECC</th>';
        $options .= '<th>TOTAL INT</th>';
        $options .= '   </tr>';
        $options .= '            
                    </thead>
                    <tbody>';
        // 
        $mun = 'null';
        $j = 0;

        $totSeccDL1 = 0;
        $totSeccDL2 = 0;
        $totSeccDL3 = 0;
        $totSeccDL4 = 0;
        $totSeccDL5 = 0;
        $totSeccDL6 = 0;
        $totSeccDL7 = 0;
        $totSeccDL8 = 0;
        $totSeccDL9 = 0;
        $totSeccDL10 = 0;
        $totSeccDL11 = 0;
        $totSeccDL12 = 0;
        $totSeccDL13 = 0;
        $totSeccDL14 = 0;
        $totSeccDL15 = 0;

        $totIntDL1 = 0;
        $totIntDL2 = 0;
        $totIntDL3 = 0;
        $totIntDL4 = 0;
        $totIntDL5 = 0;
        $totIntDL6 = 0;
        $totIntDL7 = 0;
        $totIntDL8 = 0;
        $totIntDL9 = 0;
        $totIntDL10 = 0;
        $totIntDL11 = 0;
        $totIntDL12 = 0;
        $totIntDL13 = 0;
        $totIntDL14 = 0;
        $totIntDL15 = 0;
        // 
        $totGenSecc = 0;
        $totGenInt = 0;
        //  
        // Aqui va el query de los resultados
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $totSeccDL1 += $row['totalSeccD1'];
            $totSeccDL2 += $row['totalSeccD2'];
            $totSeccDL3 += $row['totalSeccD3'];
            $totSeccDL4 += $row['totalSeccD4'];
            $totSeccDL5 += $row['totalSeccD5'];
            $totSeccDL6 += $row['totalSeccD6'];
            $totSeccDL7 += $row['totalSeccD7'];
            $totSeccDL8 += $row['totalSeccD8'];
            $totSeccDL9 += $row['totalSeccD9'];
            $totSeccDL10 += $row['totalSeccD10'];
            $totSeccDL11 += $row['totalSeccD11'];
            $totSeccDL12 += $row['totalSeccD12'];
            $totSeccDL13 += $row['totalSeccD13'];
            $totSeccDL14 += $row['totalSeccD14'];
            $totSeccDL15 += $row['totalSeccD15'];

            $totIntDL1 += $row['totalIntrD1'];
            $totIntDL2 += $row['totalIntrD2'];
            $totIntDL3 += $row['totalIntrD3'];
            $totIntDL4 += $row['totalIntrD4'];
            $totIntDL5 += $row['totalIntrD5'];
            $totIntDL6 += $row['totalIntrD6'];
            $totIntDL7 += $row['totalIntrD7'];
            $totIntDL8 += $row['totalIntrD8'];
            $totIntDL9 += $row['totalIntrD9'];
            $totIntDL10 += $row['totalIntrD10'];
            $totIntDL11 += $row['totalIntrD11'];
            $totIntDL12 += $row['totalIntrD12'];
            $totIntDL13 += $row['totalIntrD13'];
            $totIntDL14 += $row['totalIntrD14'];
            $totIntDL15 += $row['totalIntrD15'];

            $totalSecc = $row['totalSeccD1'] + $row['totalSeccD2'] + $row['totalSeccD3'] + $row['totalSeccD4'] + $row['totalSeccD5'] + $row['totalSeccD6'] + $row['totalSeccD7'] + $row['totalSeccD8'] +
                $row['totalSeccD9'] + $row['totalSeccD10'] + $row['totalSeccD11'] + $row['totalSeccD12'] + $row['totalSeccD13'] + $row['totalSeccD14'] + $row['totalSeccD15'];

            $totalInt = $row['totalIntrD1'] + $row['totalIntrD2'] + $row['totalIntrD3'] + $row['totalIntrD4'] + $row['totalIntrD5'] + $row['totalIntrD6'] + $row['totalIntrD7'] + $row['totalIntrD8'] +
                $row['totalIntrD9'] + $row['totalIntrD10'] + $row['totalIntrD11'] + $row['totalIntrD12'] + $row['totalIntrD13'] + $row['totalIntrD14'] + $row['totalIntrD15'];

            $options .= '<tr>';
            $options .= '<td style="min-width: 150px;">' . $row['municipio'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD1'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD1'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD2'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD2'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD3'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD3'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD4'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD4'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD5'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD5'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD6'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD6'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD7'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD7'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD8'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD8'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD9'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD9'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD10'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD10'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD11'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD11'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD12'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD12'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD13'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD13'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD14'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD14'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalSeccD15'] . '</td>';
            $options .= '<td style="text-align: center">' . $row['totalIntrD15'] . '</td>';
            $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totalSecc . '</td>';
            $options .= '<td style="text-align: center; background-color: chocolate ;color: white;">' . $totalInt . '</td>';
            $options .= '</tr>';

            $totGenSecc += $totalSecc;
            $totGenInt += $totalInt;
        }
        // si es falso muestra esto
        $options .= '<tr>';
        $options .= '<td style="min-width: 150px;"></td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL1 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL1 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL2 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL2 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL3 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL3 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL4 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL4 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL5 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL5 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL6 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL6 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL7 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL7 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL8 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL8 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL9 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL9 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL10 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL10 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL11 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL11 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL12 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL12 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL13 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL13 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL14 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL14 . '</td>';
        $options .= '<td style="text-align: center; background-color: #e38d13;color: white;">' . $totSeccDL15 . '</td>';
        $options .= '<td style="text-align: center; background-color: chocolate;color: white;">' . $totIntDL15 . '</td>';
        $options .= '<td style="text-align: center; background-color: maroon; color: white;"">' . $totGenSecc . '</td>';
        $options .= '<td style="text-align: center; background-color: maroon; color: white;">' . $totGenInt . '</td>';
        $options .= '</tr>';

        $options .= '</tbody>';
        // 
        $response = array(
            'success' => TRUE,
            'options' => $options
        );

        header('Content-Type: application/json');
        return $response;
    }
}
?>