<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';

// MODELO POST- CRUD

class RolModel extends Connection {
    private $table = "roles";
    
        private $id="";
        private $rol="";
        // no sé como iniciarlo private $createdAt="";
    

        function __construct(){
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
            $this->rol = $datos["rol"];
        $query = "INSERT INTO " . $this->table . "(rol) values('".$this->rol."')";
        $data=$conexion->nonQueryId($query);
    return (($data) ?  $data :  0);
    }

    public function Actualizar($datos){
        $conexion = new connection;
        
        $this->id = $datos["id"];
        if(isset($datos["rol"])){$this->rol = $datos["rol"];};
    
    $query = "UPDATE " . $this->table . " SET rol='".$this->rol."' WHERE id='".$this->id."'";
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