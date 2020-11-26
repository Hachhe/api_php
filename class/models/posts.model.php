<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';

// MODELO POST- CRUD

class PostModel extends Connection {
    private $table = "posts";
    
        private $id="";
        private $usuario_id="";
        private $titulo="";
        private $descripcion="";
        private $estado="";
        private $categoria_id="";
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
        
            $this->usuario_id = $datos["usuario_id"];
            $this->titulo = $datos["titulo"];
            $this->descripcion = $datos["descripcion"];
            $this->estado = $datos["estado"];
            $this->categoria_id = $datos["categoria_id"];
    
    $query = "INSERT INTO " . $this->table . "(usuario_id,titulo, descripcion, estado,categoria_id) 
    values
    ('".$this->usuario_id."','".
    $this->titulo."','".
    $this->descripcion."','".
    $this->estado."','".
    $this->categoria_id."')";
    $data=$conexion->nonQueryId($query);
    return (($data) ?  $data :  0);
    }

    public function Actualizar($datos){
        $conexion = new connection;
        
        $this->id = $datos["id"];
        if(isset($datos["usuario_id"])){$this->usuario_id = $datos["usuario_id"];};
        if(isset($datos["titulo"])){$this->titulo = $datos["titulo"];};
        if(isset($datos["descripcion"])){$this->descripcion = $datos["descripcion"];};
        if(isset($datos["estado"])){ $this->estado = $datos["estado"];};
        if(isset($datos["categoria_id"])){$this->categoria_id = $datos["categoria_id"];};
    
    $query = "UPDATE " . $this->table . " SET usuario_id='".$this->usuario_id."', titulo='".$this->titulo."', descripcion='".$this->descripcion."', estado='".$this->estado."', categoria_id='".$this->categoria_id."' WHERE id='".$this->id."'";
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