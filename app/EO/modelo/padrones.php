<?php
    // include_once('../../../config/database.php');
    if(file_exists('../../../config/database.php'))
        include_once('../../../config/database.php');
    if(file_exists('../../../../config/database.php'))
        include_once('../../../../config/database.php');
    $pdo = Database::getInstance()->getPdoObject();

class Padrones{
	private static $instance = null;

    public function __construct()
    {
        self::getInstance();
    }

    public static function getInstance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Padrones();
        }

        return self::$instance;
    }
    public function Crear($nombre,$idEnalce,$idPersona){
        try{
            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO segmento(Nombre_Seg,Id_Enlace,Id_Persona) 
            VALUES ('$nombre', '$idEnalce','$idPersona')");
            $stmt->execute();
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }    
    // 
    function Editar($idPersona,$nombre,$apellidoP,$apellidoM,$correo,$telefono,$user,$pass){
        try{        
           $stmt = $GLOBALS['pdo']->prepare("UPDATE recolectores SET Nombre='$nombre',App='$apellidoP',Apm='$apellidoM',Correo='$correo',Telefono='$telefono', User ='$user', Contraseña='$pass' WHERE Id=$idPersona");    
           $stmt->execute();
           return $stmt;
       }
       catch (PDOException $err)
       {
           return $err->getMessage();
       }
   }
   public function Borrar($id){
        try{
            // $stmt = $GLOBALS['pdo']->prepare("DELETE FROM recolectores WHERE Id='$id'");
            $stmt = $GLOBALS['pdo']->prepare("DELETE FROM padrones WHERE Id_Padron='$id'");
            $stmt->execute();

            return $stmt;
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }
    // 
    public function CrearDetalle($idPadron,$idPersona){
        try{
            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO detalle_padron(Id_Padron,Id_Contacto) 
            VALUES ('$idPadron','$idPersona')");
            $stmt->execute();
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    } 
}
?>