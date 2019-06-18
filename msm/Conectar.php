<?php
class Conectar {
    public static function getConexion(){
        //$conn = new PDO('mysql:host=localhost;dbname=InfraestructuraEstadistica', "root", "123abc",array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        $conn = new PDO('mysql:host=localhost;dbname=lbase', "root", "",array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
	    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
?>