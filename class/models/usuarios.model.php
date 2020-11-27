<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once 'utils/encript.php';

// MODELO POST- CRUD

class UsuarioModel extends Connection {
    private $table = "usuarios";
    
        private $id="";
        private $nombre="";
        private $apellido="";
        private $email="";
        private $mobile="";
        private $password="";
        private $rol_id="";
        private $created_At="";
    

        function __construct(){
            $this->created_At=date("Y-m-d H:i:s");
        }

    public function getAll($inicio, $cantidad){
        $conexion = new connection;
        $query = "SELECT * from " . $this->table. " limit $inicio, $cantidad";
        $data = $conexion->obtenerDatos($query);
        return (isset($data[0])) ? $data : 0;
    }

    public function getById($id){
        $conexion = new connection;
        $query = "SELECT * from " . $this->table. " WHERE id='$id'";
        $data = $conexion->obtenerDatos($query);
        return (isset($data[0])) ? $data : 0;
    }

    public function Enviar($datos){
        $conexion = new connection;

        $this->nombre=$datos["nombre"];
        $this->apellido=$datos["apellido"];
        $this->email=$datos["email"];
        if(isset($datos["mobile"])){$this->mobile = $datos["mobile"];};
        $this->password=encriptar($datos["password"]);
        $this->rol_id=$datos["rol_id"];
                    
    $query = "INSERT INTO " . $this->table . "(nombre, apellido, email, mobile, password, rol_id, created_At) 
    values
    ('".$this->nombre."','".
    $this->apellido."','".
    $this->email."','".
    $this->mobile."','".
    $this->password."','".
    $this->rol_id."','".
    $this->created_At."')";
    $data=$conexion->nonQueryId($query);
    print_r($query);
    return (($data) ?  $data :  0);
    }

    public function Actualizar($datos){
        $conexion = new connection;
        
        $this->id = $datos["id"];
        if(isset($datos["nombre"])){$this->nombre = $datos["nombre"];};
        if(isset($datos["apellido"])){$this->apellido = $datos["apellido"];};
        if(isset($datos["email"])){$this->email = $datos["email"];};
        if(isset($datos["mobile"])){$this->mobile = $datos["mobile"];};
        if(isset($datos["password"])){ $this->password = $datos["password"];};
        if(isset($datos["rol_id"])){$this->rol_id = $datos["rol_id"];};
    
    $query = "UPDATE " . $this->table . " SET nombre='".$this->nombre."', apellido='".$this->apellido."', email='".$this->email."', mobile='".$this->mobile."', password='".$this->password."', rol_id='".$this->rol_id."', created_At='".$this->created_At.'" WHERE id="'.$this->id."'";
    $data=$conexion->nonQuery($query);
    return (($data>=1) ?  $data :  0); 
    }

    public function Eliminar($datos){
        $conexion = new connection;    
        $this->id = $datos["id"];
    $query = "DELETE FROM " . $this->table . " WHERE id='".$this->id."'";
    print_r($query);
    $data=$conexion->nonQuery($query);
    return (($data>=1) ?  $data :  0); 
    
    }

}