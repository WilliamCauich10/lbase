<?php
    require_once 'Conectar.php';
    $lista = array();

    $conexion = Conectar::getConexion();

    $IdMensaje = $_GET['IdMensaje'];
    $sql = "update Mensajes set Estatus = 2 where IdMensaje = :IdMensaje ";
    $prepare = $conexion->prepare($sql);
    $prepare->execute(array('IdMensaje'=>$IdMensaje));
    
    array_push($lista,array(
        'exito'=>1)
    );

    echo json_encode($lista);
       
?>