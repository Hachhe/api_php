<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once 'utils/encript.php';
require_once 'auth.clase.php';

// MODELO POST- CRUD

class UsuarioModel extends Connection {
    private $table = "usuarios";
    private $roles = "roles";
    
        private $id="";
        private $nombre="";
        private $apellido="";
        private $email="";
        private $mobile="";
        private $password="";
        private $rol_id="";
        private $createdAt="";
    

        function __construct(){
            $this->createdAt=date("Y-m-d H:i:s");
        }

      public function getAll($pagina, $cantidad){
          $_respuesta = new respuestas;
          $conexion = new connection;
          $offset = ($cantidad * $pagina)-$cantidad;
            $query= "
            SELECT u.id, u.nombre, u.apellido, u.email, u.mobile, u.rol_id, u.createdAt, r.rol
            from " . $this->table. " as u JOIN ". $this->roles. " as r ON u.rol_id = r.id limit $cantidad offset $offset";
            $data = $conexion->obtenerDatos($query);
            return (isset($data[0])) ? $data : 0;
    }

    public function getById($id){
        $conexion = new connection;
        $headers = apache_request_headers();
        $_respuesta = new respuestas;

        if(isset($headers['token'])){
           $token = $headers['token'];
             if(Auth::Check($token)){
                $query = "SELECT u.id, u.nombre, u.apellido, u.email, u.mobile, u.password, u.rol_id, u.createdAt, r.rol
                from " . $this->table. " as u JOIN ". $this->roles. " as r ON u.rol_id = r.id WHERE u.id='$id'";
                $data = $conexion->obtenerDatos($query);
                return (isset($data[0])) ? $data[0] : 0;
            }else
             return 0;
       }else{
         return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
       } 
    }

    public function Enviar($datos){
        $conexion = new connection;
        $_respuesta = new respuestas;

        $this->nombre=$datos["nombre"];
        $this->apellido=$datos["apellido"];
        $this->email=$datos["email"];
        if(isset($datos["mobile"])){$this->mobile = $datos["mobile"];};
        $this->password=($datos["password"]);
        $this->rol_id=$datos["rol_id"];

      $query = "INSERT INTO " . $this->table . "(nombre, apellido, email, mobile, password, rol_id, createdAt) 
      values
      ('".$this->nombre."','".
         $this->apellido."','".
         $this->email."','".
         $this->mobile."','".
         $this->password."','".
         $this->rol_id."','".
         $this->createdAt."')";
         $data=$conexion->nonQueryId($query);
      return (($data) ?  $data :  0);
    }

    public function Actualizar($datos){
        $conexion = new connection;
         $_respuesta = new respuestas;
         $obtener = $this->getById($datos["id"]);
        $this->id = $datos["id"];

        if(isset($datos["nombre"])){$this->nombre = $datos["nombre"];}
        else{$this->nombre = $obtener["nombre"];};

        if(isset($datos["apellido"])){$this->apellido = $datos["apellido"];}
        else{$this->apellido = $obtener["apellido"];};

        if(isset($datos["email"])){$this->email = $datos["email"];}
        else{$this->email = $obtener["email"];};

        if(isset($datos["mobile"])){$this->mobile = $datos["mobile"];}
        else{$this->mobile = $obtener["mobile"];};

        if(isset($datos["password"])){ $this->password = $datos["password"];}
        else{$this->password = $obtener["password"];};

        if(isset($datos["rol_id"])){$this->rol_id = $datos["rol_id"];}
        else{$this->rol_id = $obtener["rol_id"];};
        $headers = apache_request_headers();

        if(isset($headers['token'])){
           $token = $headers['token'];
             if(Auth::Check($token)){
                $query = "UPDATE " . $this->table . " SET nombre='".$this->nombre."', apellido='".$this->apellido."', email='".$this->email."', mobile='".$this->mobile."', password='".$this->password."', rol_id='".$this->rol_id."', createdAt='".$this->createdAt."' WHERE id='".$this->id."'";
                $data=$conexion->nonQuery($query);
                return (($data>=1) ?  $data :  0);
            }else
             return 0;
       }else{
         return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
       }  
    }

    public function Eliminar($datos){
        $conexion = new connection;    
        $_respuesta = new respuestas;
        $this->id = $datos["id"];
        $headers = apache_request_headers();

        if(isset($headers['token'])){
           $token = $headers['token'];
             if(Auth::Check($token)){
                $query = "DELETE FROM " . $this->table . " WHERE id='".$this->id."'";
                $data=$conexion->nonQuery($query);
                return (($data>=1) ?  $data :  0); 
            }else
             return 0;
       }else{
         return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
       }  
    }

}