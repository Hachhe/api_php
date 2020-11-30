<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once 'auth.clase.php';
require_once './class/models/posts.model.php';

// MODELO POST- CRUD

class PostModel extends Connection {
    private $table = "posts";
    private $categorias = "categorias";
    private $usuarios = "usuarios";
    
        private $id="";
        private $usuario_id="";
        private $titulo="";
        private $descripcion="";
        private $estado="";
        private $fuente="";
        private $categoria_id="";
        private $created_At="";
    

        function __construct(){
            $this->created_At=date("Y-m-d H:i:s");
        }

    public function getAll($pagina, $cantidad){
        $_respuesta = new respuestas;
        $conexion = new connection;
        $offset = ($cantidad * $pagina)-$cantidad;
       $query = " SELECT p.id, p.usuario_id, p.titulo, p.descripcion, p.fuente, p.createdAt,
       u.nombre, u.email, u.created_At,
       c.categoria from " . $this->table."
       as p JOIN ".$this->usuarios."  as u ON p.usuario_id = u.id JOIN ".$this->categorias." as c ON p.categoria_id= c.id
       limit $cantidad offset $offset";
       $data = $conexion->obtenerDatos($query);

    return (isset($data[0])) ? $data : 0;
        
    }

    public function getById($id){
        $conexion = new connection;
        $headers = apache_request_headers();
        
        if(isset($headers['token'])){
          $token = $headers['token'];
            if(Auth::Check($token)){
                $query = "SELECT p.id, p.usuario_id, p.titulo, p.descripcion, p.fuente, p.createdAt,
                u.nombre, u.email, c.categoria from " . $this->table." as p 
                JOIN ".$this->usuarios." as u ON p.usuario_id = u.id
                JOIN ".$this->categorias." as c ON p.categoria_id = c.id
                WHERE p.id='$id'";
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
        
            $this->usuario_id = $datos["usuario_id"];
            $this->titulo = $datos["titulo"];
            $this->descripcion = $datos["descripcion"];
            $this->estado = $datos["estado"];
            $this->fuente = $datos["fuente"];
            $this->categoria_id = $datos["categoria_id"];
    
            $headers = apache_request_headers();

            if(isset($headers['token'])){
              $token = $headers['token'];
                if(Auth::Check($token)){
                    $query = "INSERT INTO " . $this->table . "(usuario_id,titulo, descripcion, estado,categoria_id, created_At) 
                    values
                    ('".$this->usuario_id."','".
                    $this->titulo."','".
                    $this->descripcion."','".
                    $this->estado."','".
                    $this->fuente."','".
                    $this->categoria_id."','".
                    $this->created_At."')";
                    $data=$conexion->nonQueryId($query);
                    return (($data) ?  $data :  0);
                }else
                    return 0;
            }else{
                return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
            }
    
            
    }

    public function Actualizar($datos){
        $conexion = new connection;
        $headers = apache_request_headers();
        $this->id = $datos["id"];
        if(isset($datos["usuario_id"])){$this->usuario_id = $datos["usuario_id"];};
        if(isset($datos["titulo"])){$this->titulo = $datos["titulo"];};
        if(isset($datos["descripcion"])){$this->descripcion = $datos["descripcion"];};
        if(isset($datos["estado"])){ $this->estado = $datos["estado"];};
        if(isset($datos["fuente"])){ $this->fuente = $datos["fuente"];};
        if(isset($datos["categoria_id"])){$this->categoria_id = $datos["categoria_id"];};
    
        if(isset($headers['token'])){
          $token = $headers['token'];
            if(Auth::Check($token)){
             $query = "UPDATE " . $this->table . " SET usuario_id='".$this->usuario_id."', titulo='".$this->titulo."', descripcion='".$this->descripcion."', estado='".$this->estado."', categoria_id='".$this->categoria_id."', created_At='".$this->created_At.'" WHERE id="'.$this->id."'";
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
        if(isset($headers['token'])){
            $token = $headers['token'];
              if(Auth::Check($token)){
                $this->id = $datos["id"];
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