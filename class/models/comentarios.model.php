<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';

// MODELO POST- CRUD

class ComentarioModel extends Connection {
    private $table = "comentarios";
    
        private $id="";
        private $post_id="";
        private $titulo="";
        private $descripcion="";
        private $estado="";
        private $createdAt="";
    

        function __construct(){
            $this->createdAt=date("Y-m-d H:i");
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
        
            $this->post_id = $datos["post_id"];
            $this->titulo = $datos["titulo"];
            $this->descripcion = $datos["descripcion"];
            $this->estado = $datos["estado"];
            $this->createdAt= $datos["createdAt"];
    
    $query = "INSERT INTO " . $this->table . "(post_id,titulo, descripcion, estado, createdAt) 
    values
    ('".$this->post_id."','".
    $this->titulo."','".
    $this->descripcion."','".
    $this->estado."','".
    $this->createdAt."')";
    $data=$conexion->nonQueryId($query);
    return (($data) ?  $data :  0);
    }

    public function Actualizar($datos){
        $conexion = new connection;
        
        $this->id = $datos["id"];
        if(isset($datos["post_id"])){$this->post_id = $datos["post_id"];};
        if(isset($datos["titulo"])){$this->titulo = $datos["titulo"];};
        if(isset($datos["descripcion"])){$this->descripcion = $datos["descripcion"];};
        if(isset($datos["estado"])){ $this->estado = $datos["estado"];};
        if(isset($datos["createdAt"])){$this->createdAt = $datos["createdAt"];};
    
    $query = "UPDATE " . $this->table . " SET post_id='".$this->post_id."', titulo='".$this->titulo."', descripcion='".$this->descripcion."', estado='".$this->estado."', createdAt='".$this->createdAt."' WHERE id='".$this->id."'";
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