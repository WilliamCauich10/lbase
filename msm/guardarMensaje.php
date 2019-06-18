<?php
    require_once 'Conectar.php';
    $lista = array();

    $conexion = Conectar::getConexion();

    $Emisor = $_GET['Emisor'];
    $Receptor = $_GET['Receptor'];
    $Mensaje = $_GET['Mensaje'];

    $sql = "insert into Mensajes (IdTipoMensaje,Emisor,Receptor,Mensaje,Estatus) value (2,:Emisor,:Receptor,:Mensaje,0)";
    $prepare = $conexion->prepare($sql);
    $prepare->execute(array(
        'Emisor'=>$Emisor,
        'Receptor'=>$Receptor,
        'Mensaje'=>$Mensaje
    ));
    
    array_push($lista,array(
        'exito'=>1)
    );

    echo json_encode($lista);
       
?>