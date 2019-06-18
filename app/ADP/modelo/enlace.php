<?php
    include_once('../../../config/database.php');
    $pdo = Database::getInstance()->getPdoObject();

class Enlace{
	private static $instance = null;

    public function __construct()
    {
        self::getInstance();
    }

    public static function getInstance() {
        if( is_null( self::$instance ) ) {
            self::$instance = new Enlace();
        }

        return self::$instance;
    }
    public function CrearEnlace($Id_Proyecto,$id_User,$id_perfil,$NombreEnlace){
        try{
            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO enlaces_operativos(Id_Proyecto,Id_Contacto,Id_Perfil,Nombre_Enlace) 
            VALUES ('$Id_Proyecto', '$id_User','$id_perfil','$NombreEnlace')");
            $stmt->execute();
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }   
    public function UpdateEnlace($id_User,$enlace){
        try{
            $stmt = $GLOBALS['pdo']->prepare("UPDATE contactos SET Id_Enlace='$enlace' WHERE Id_Contacto=$id_User");
            $stmt->execute();
        }
        catch (PDOException $err)
        {
            return $err->getMessage();
        }
    }   
    // 
    public function CrearUser($idPerfil,$nombre,$app,$apm,$direccion,$telfono,$correo,$contraseña,$idCaombio,$Seccion,$enlace,$proyecto){
        try{
            // $stmt = $GLOBALS['pdo']->prepare("INSERT INTO contactos (Id_perfil,Nombre,Ape_Pat,APe_Mat,Direccion,Telefono,Correo,Psw,id_cambio,Seccion)
            // SELECT * FROM (SELECT '$idPerfil','$nombre','$app','$apm','$direccion','$telfono','$correo','$contraseña','$idCaombio','$Seccion') AS tmp
            // WHERE NOT EXISTS (
            //     SELECT Correo,id_cambio FROM contactos WHERE Correo = '$correo' AND  id_cambio !='0'
            // ) LIMIT 1;");
            // $stmt->execute();
            $stmt = $GLOBALS['pdo']->prepare("INSERT INTO contactos(Id_perfil,Nombre,Ape_Pat,APe_Mat,Direccion,Telefono,Correo,Psw,id_cambio,Seccion,Id_Enlace,Id_Proyecto) 
            VALUES ('$idPerfil','$nombre','$app','$apm','$direccion','$telfono','$correo','$contraseña','$idCaombio','$Seccion','$enlace','$proyecto')");
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