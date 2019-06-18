<?php
require_once "global.php";

class Database {
    private static $instance = null;
    private $pdoObject;
    private function __construct() {
        $this->pdoObject = new PDO('mysql:host=' . DB_HOST . ';charset=' . DB_ENCODE . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    }

    public static function getInstance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getPdoObject() {
        return $this->pdoObject;
    }

}
?>