<?php
session_start();
include_once('../../config/database.php');
$pdo = Database::getInstance()->getPdoObject();
$tipo = $_GET["tipo"];
$tipo();
function EO(){
    try{
        $municipio = $_GET["municipio"];
    
        $sql = " SELECT S.Id_seg,S.Nombre_Seg AS segmento, IFNULL(COUNT(P.Id_Padron),0) AS total, count(DISTINCT C2.Seccion) as totalSeccion
            FROM segmento AS S
            LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
            LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
            LEFT JOIN contactos AS C ON S.Id_Persona = C.Id_Contacto
            LEFT JOIN contactos AS C2 ON P.Id_Persona = C2.Id_Contacto
            LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
            WHERE S.Id_Enlace = :enlace ";
    
        if ($municipio != 0) {
            $sql .= " AND
                    SE.MUNICIPIO = :municipio ";
        }
    
        $sql .= "GROUP BY S.Nombre_Seg";
    
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->bindValue(':enlace', $_SESSION['Id_EnlaceOP']);
    
        if ($municipio != 0) {
            $stmt->bindParam(':municipio', $municipio);
        }
        $stmt->execute();
    
        $options = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= '<h4>' . $row['segmento'] . '</h4>';
    
            $options .= '<h4>usuarios</h4>';
    
            $sql2 = "SELECT C.*,S.*,CAT.* FROM contactos AS C 
                    INNER JOIN padrones AS P ON P.Id_Persona = C.Id_Contacto
                    INNER JOIN secciones AS S ON C.Seccion = S.SECCION
                    INNER JOIN catgeo AS CAT ON S.MUNICIPIO = CAT.id_ine
                    WHERE
                        P.Id_Segmento = :idSeg 
                    AND
                        C.Id_Enlace = :idEnl  ";
    
            if ($municipio != '')
            {
                $sql2 .= " AND S.MUNICIPIO = :municipio ";
            }
            $stmt2 = $GLOBALS['pdo']->prepare($sql2);
            $stmt2->bindValue(':idEnl', $_SESSION['Id_EnlaceOP']);
    
            if ($municipio != '')
            {
                $stmt2->bindValue(':municipio', $municipio);
            }
            $stmt2->bindParam(':idSeg', $row['Id_seg']);
            $stmt2->execute();    
            $options .= '<table class= "bordered striped">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido paterno</th>
                                <th>Apellido materno</th>
                                <th>Sección</th>
                                <th>Distrito Local</th>
                                <th>Municipio</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>Teléfono</th>                                                     
                                
                            </tr>';
    
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {    
                $options .= '<tr>
                                <td>' . $row2['Nombre'] . '</td>
                                <td>' . $row2['Ape_Pat'] . '</td>
                                <td>' . $row2['APe_Mat'] . '</td>
                                <td>' . $row2['Seccion'] . '</td>
                                <td>' . $row2['DISTRITO_L'] . '</td>
                                <td>' . $row2['nom_geo'] . '</td>
                                <td>' . $row2['Direccion'] . '</td>
                                <td>' . $row2['Correo'] . '</td>
                                <td>' . $row2['Telefono'] . '</td>                            
                            </tr>';
            }
    
            $options .= '</table>';
        }
        $options = chr(239) . chr(187) . chr(191) . $options;
    
        header('Content-Encoding: UTF-8');
        header('Content-Type: application/x-msexcel');
        header('Content-Disposition: attachment; filename=exportacionPorMunicipio.xls');
        echo $options;
    }catch (PDOException $err){
        return $err->getMessage();
    }
}
function PA(){
    try{
        $municipio = $_GET["municipio"];
    
        $sql = "SELECT P.Id_Padron,P.Nom_Padron, IFNULL(COUNT(D.Id_Padron),0) AS total, count(DISTINCT C.Seccion) as totalSeccion
            FROM segmento AS S
            LEFT JOIN padrones AS P ON S.Id_seg = P.Id_Segmento
            LEFT JOIN detalle_padron AS D ON P.Id_Padron = D.Id_Padron
            LEFT JOIN contactos AS C ON P.Id_Persona = C.Id_Contacto
            LEFT JOIN secciones AS SE ON C.Seccion = SE.SECCION
            WHERE P.Id_Segmento = :segmento ";
    
        if ($municipio != 0) {
            $sql .= " AND
                    SE.MUNICIPIO = :municipio ";
        }
    
        $sql .= " GROUP BY P.Nom_Padron";
    
        $stmt = $GLOBALS['pdo']->prepare($sql);
        $stmt->bindValue(':segmento', $_SESSION['Id_Segmento']);
    
        if ($municipio != 0) {
            $stmt->bindParam(':municipio', $municipio);
        }
        $stmt->execute();
    
        $options = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= '<h4>' . $row['Nom_Padron'] . '</h4>';
    
            $options .= '<h4>Usuarios</h4>';
    
            $sql2 = "SELECT C.*,S.*,CAT.* FROM detalle_padron AS D
                INNER JOIN contactos AS C ON D.Id_Contacto = C.Id_Contacto
                INNER JOIN secciones AS S ON C.Seccion = S.SECCION
                INNER JOIN catgeo AS CAT ON S.MUNICIPIO = CAT.id_ine
                LEFT JOIN padrones AS P ON D.Id_Padron = P.Id_Padron 
                WHERE 
                    P.Id_Padron = :idPa 
                AND 
                    C.Id_Enlace = :idEnl ";
    
            // if ($municipio != '')
            // {
            //     $sql2 .= " AND S.MUNICIPIO = :municipio ";
            // }
            $sql2 .= "GROUP BY D.Id_Contacto";
            $stmt2 = $GLOBALS['pdo']->prepare($sql2);
            $stmt2->bindValue(':idEnl', $_SESSION['Id_EnlaceOP']);
    
            // if ($municipio != '')
            // {
            //     $stmt2->bindValue(':municipio', $municipio);
            // }
            $stmt2->bindParam(':idPa', $row['Id_Padron']);
            $stmt2->execute();
    
            $options .= '<table class= "bordered striped">
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido paterno</th>
                                <th>Apellido materno</th>
                                <th>Sección</th>
                                <th>Distrito Local</th>
                                <th>Municipio</th>
                                <th>Dirección</th>
                                <th>Correo</th>
                                <th>Teléfono</th>                                                     
                                
                            </tr>';
    
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {    
                $options .= '<tr>
                                <td>' . $row2['Nombre'] . '</td>
                                <td>' . $row2['Ape_Pat'] . '</td>
                                <td>' . $row2['APe_Mat'] . '</td>
                                <td>' . $row2['Seccion'] . '</td>
                                <td>' . $row2['DISTRITO_L'] . '</td>
                                <td>' . $row2['nom_geo'] . '</td>
                                <td>' . $row2['Direccion'] . '</td>
                                <td>' . $row2['Correo'] . '</td>
                                <td>' . $row2['Telefono'] . '</td>                            
                            </tr>';
            }    
            $options .= '</table>';
        }    
        $options = chr(239) . chr(187) . chr(191) . $options;
    
        header('Content-Encoding: UTF-8');
        header('Content-Type: application/x-msexcel');
        header('Content-Disposition: attachment; filename=exportacionPorMunicipio.xls');
        echo $options;
    }catch (PDOException $err){
        return $err->getMessage();
    }
}
