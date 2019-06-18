<?php
session_start();
include_once('config/database.php');
$pdo = Database::getInstance()->getPdoObject();

if(isset($_POST['exampleInputEmail1']) && isset($_POST['exampleInputPassword1'])):
    $user = $_POST['exampleInputEmail1'];
    $password = $_POST['exampleInputPassword1'];
    // echo $user."<br>".$password;
    $stmt = $pdo -> prepare("SELECT T2.*,T3.*,T1.Id_Proyecto AS Enlace  FROM contactos AS T2 
    LEFT JOIN proyecto AS T1 ON T1.Id_Responsable = T2.Id_Contacto
    INNER JOIN perfil AS T3 ON T1.Id_Perfil = T3.Id_Perfil
    WHERE T2.Correo =  :user AND T2.Psw = :password AND T2.id_cambio ='0'
UNION    
	 SELECT T2.*,T3.*,T4.Id_Enlace AS Enlace  FROM contactos AS T2 
	 LEFT JOIN enlaces_operativos AS T4 ON T2.Id_Contacto = T4.Id_Contacto
	 INNER JOIN perfil AS T3 ON T4.Id_Perfil = T3.Id_Perfil
     WHERE T2.Correo =  :user AND T2.Psw = :password AND T2.id_cambio ='0'
UNION 
    SELECT T2.*,T3.*,T4.Id_seg AS Enlace FROM contactos AS T2 
    LEFT JOIN segmento AS T4 ON T2.Id_Contacto = T4.Id_Persona
    INNER JOIN perfil AS T3 ON T2.Id_perfil = T3.Id_Perfil
    INNER JOIN proyecto AS P ON T2.Id_Proyecto = P.Id_Proyecto
    WHERE T2.Correo =  :user AND T2.Psw = :password AND T3.Id_Perfil = 4");
//  LEFT JOIN enlaces_operativos AS T4 ON T2.Id_Contacto = T4.Id_Responsable
    $stmt -> bindParam(":user",$user, PDO::PARAM_STR);
    $stmt -> bindParam(":password",$password, PDO::PARAM_STR);
    // $stmt -> bindValue(":estate", 1, PDO::PARAM_INT);
    $execute = $stmt -> execute();
// echo $execute;
    if($execute === true): 
        $row = $stmt -> fetch();        
        $_SESSION['id_usuario'] = $row['Id_Contacto'];
        $_SESSION['nombre'] = utf8_encode($row['Nombre']);
        $_SESSION['apellido_paterno'] = utf8_encode($row['Ape_Pat']);
        $_SESSION['Nom_proyecto'] = $row['Proyecto'];
        $_SESSION['usuario'] = utf8_encode($row['Correo']);
        $_SESSION['Fecha_hoy'] = date("Y-m-d");
        $_SESSION['tipo_usuario'] = $row['Abreviacion'];
        $id =$_SESSION['id_usuario'];
        if ($_SESSION['tipo_usuario'] == 'EO') {
            $_SESSION['Id_EnlaceOP'] = $row['Enlace'];
            $Results = $pdo -> prepare("SELECT T1.Id_Proyecto FROM contactos AS T1 WHERE T1.Id_Contacto ='$id'");
            $execute2 = $Results -> execute();
            // $row = $stmt -> fetch();
            while( $row2 = $Results -> fetch()){
                $_SESSION['id_proyecto'] = $row['Id_Proyecto'];
            }
        }elseif ($_SESSION['tipo_usuario'] == 'ADP') {
            $_SESSION['Id_EnlaceOP'] = "Null";
            $_SESSION['id_proyecto'] = $row['Enlace'];//proyecto
        }elseif ($_SESSION['tipo_usuario'] == 'PA') {
            $_SESSION['id_P'] =0;//id Padron
            $_SESSION['NPadrom'] = 'NA';//NPadrom
            $_SESSION['Id_Segmento'] = $row['Enlace'];//segmento
            $_SESSION['Id_EnlaceOP'] = $row['Id_Enlace'];
            $_SESSION['id_proyecto'] = $row['Id_Proyecto'];
        }else{}
        // $hoy = date("Y-m-d");
    else:        
       header('Location: index.php');    
    endif;
    // echo 'prueba ->'.$user;
        // $stmt2 = $pdo -> prepare("SELECT T2.*,T3.*,T4.Id_Enlace AS Enlace,P.Proyecto FROM contactos AS T2 
        //     LEFT JOIN segmento AS T4 ON T2.Id_Contacto = T4.Id_Persona
        //     INNER JOIN perfil AS T3 ON T2.Id_perfil = T3.Id_Perfil
        //     INNER JOIN proyecto AS P ON t2.Id_Proyecto = P.Id_Proyecto
        //     WHERE T2.Correo =  :user AND T2.Psw = :password AND T3.Id_Perfil = 4");
        // $stmt2 -> bindParam(":user",$user, PDO::PARAM_STR);
        // $stmt2 -> bindParam(":password",$password, PDO::PARAM_STR);
        // $execute2 = $stmt2 -> execute();
        // if($execute2 === true): 
        //     $row2 = $stmt2 -> fetch();
        //     $_SESSION['id_usuario'] = $row2['Id_Contacto'];
        //     $_SESSION['nombre'] = utf8_encode($row2['Nombre']);
        //     $_SESSION['apellido_paterno'] = utf8_encode($row2['Ape_Pat']);
        //     $_SESSION['Nom_proyecto'] = $row2['Proyecto'];
        //     $_SESSION['usuario'] = utf8_encode($row2['Correo']);
        //     $_SESSION['Fecha_hoy'] = date("Y-m-d");
        //     $_SESSION['tipo_usuario'] = $row2['Abreviacion'];
        //     $_SESSION['Id_EnlaceOP'] = $row2['Enlace'];           
        // else:
        //     header('Location: index.php');
        // endif;
endif;

if(!isset($_SESSION['id_usuario'])):
    $_SESSION = array();
    session_destroy();
   header('Location: login.php');
    else:
        header('Location: inicio.php');
endif;

if($_GET['logout'] === 'logout'):
    $_SESSION = array();
    session_destroy();
    header('Location: login.php');
endif;
