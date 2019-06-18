<?php
    require_once 'Conectar.php';
    $lista = array();

    $conexion = Conectar::getConexion();

    $sql = "select * from Mensajes where Estatus = 0 and IdTipoMensaje = 1  ";
            $prepare = $conexion->prepare($sql);
            $prepare->execute();
            $resultado = $prepare->fetchAll();
            $lista = array();
            foreach ($resultado as $row) {
                array_push($lista,array(
                    'IdMensaje' => $row['IdMensaje'],
                    'Receptor' => $row['Receptor'],
                    'Mensaje'  => $row['Mensaje']
                ));
            }

    $sql = "update Mensajes set Estatus = 1 where IdMensaje = :IdMensaje ";
    for($i=0;$i<count($lista);$i++){
        $prepare = $conexion->prepare($sql);
        $prepare->execute(array('IdMensaje'=>$lista[$i]['IdMensaje']));
    }
    
    echo json_encode($lista);
       
?>