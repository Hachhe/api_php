<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';

// MODELO POST- CRUD

class CategoriaModel extends Connection {
    private $table = "categorias";
    
        private $id="";
        private $categoria="";
    

        function __construct(){
        }
    public function getAll($pagina, $cantidad){
        $_respuesta = new respuestas;
        $conexion = new connection;
        $offset = ($cantidad * $pagina)-$cantidad;
        $query = "SELECT * from " . $this->table. " limit $cantidad offset $offset";
        $data = $conexion->obtenerDatos($query);
        return (isset($data[0])) ? $data : 0;
    }

    public function getById($id){
        $conexion = new connection;
        $query = "SELECT * from " . $this->table. " WHERE id='$id'";
        $data = $conexion->obtenerDatos($query);
        return (isset($data[0])) ? $data[0] : 0;
    }

    public function Enviar($datos){
        $conexion = new connection;
            $this->categoria = $datos["categoria"];
        $query = "INSERT INTO " . $this->table . "(categoria) values('".$this->categoria."')";
        $data=$conexion->nonQueryId($query);
    return (($data) ?  $data :  0);
    }

    public function Actualizar($datos){
        $conexion = new connection;
        
        $this->id = $datos["id"];
        if(isset($datos["categoria"])){$this->categoria = $datos["categoria"];};
    
    $query = "UPDATE " . $this->table . " SET categoria='".$this->categoria."' WHERE id='".$this->id."'";
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