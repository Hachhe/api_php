<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once 'auth.clase.php';

// MODELO POST- CRUD

class ComentarioModel extends Connection {
    private $table = "comentarios";
    private $usuarios = "usuarios";
    private $roles = "roles";
    
        private $id="";
        private $post_id="";
        private $usuario_id="";
        private $comentario="";
        private $createdAt="";
    

        function __construct(){
            $this->createdAt=date("Y-m-d H:i");
        }

    public function getAll($pagina, $cantidad){
        $_respuesta = new respuestas;
        $conexion = new connection;
        $offset = ($cantidad * $pagina)-$cantidad;
        $query = 
        "SELECT c.id, c.post_id, c.usuario_id, c.comentario, c.createdAt,
        u.nombre, u.email, r.rol 
        from " . $this->table." as c 
        JOIN ".$this->usuarios." as u ON c.usuario_id= u.id 
        JOIN ".$this->roles." as r ON u.rol_id = r.id
        limit $cantidad offset $offset";
        $data = $conexion->obtenerDatos($query);
        return (isset($data[0])) ? $data : 0;
    }

    public function getById($id){
        $_respuesta = new respuestas;
        $conexion = new connection;
        $headers = apache_request_headers();
        if(isset($headers['token'])){
            $token = $headers['token'];
              if(Auth::Check($token)){
                $query= 
                "SELECT c.id, c.post_id, c.usuario_id, c.comentario, c.createdAt,
                u.nombre, u.email, r.rol 
                from " . $this->table." as c 
                JOIN ".$this->usuarios." as u ON c.usuario_id= u.id 
                JOIN ".$this->roles." as r ON u.rol_id = r.id
                WHERE c.id='$id'";
                $data = $conexion->obtenerDatos($query);
                return (isset($data[0])) ? $data[0] : 0;
              }else
                  return 0;
          }else{
              return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
          }
    }

    public function Enviar($datos){
        $_respuesta = new respuestas;
        $conexion = new connection;
        
            $this->post_id = $datos["post_id"];
            $this->usuario_id = $datos["usuario_id"];
            $this->comentario = $datos["comentario"];
            $this->createdAt= $datos["createdAt"];

        $headers = apache_request_headers();

         if(isset($headers['token'])){
            $token = $headers['token'];
              if(Auth::Check($token)){
                $query = "INSERT INTO " . $this->table . "(post_id, usuario_id ,comentario, createdAt) 
                values
                ('".$this->post_id."','".
                $this->usuario_id."','".
                $this->comentario."','".
                $this->createdAt."')";
                $data=$conexion->nonQueryId($query);
                return (($data) ?  $data :  0);
            }else
                  return 0;
        }else{
              return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
        }
    }

    public function Actualizar($datos){
        $_respuesta = new respuestas;
        $conexion = new connection;
        $obtener = $this->getById($datos["id"]);
        
        $this->id = $datos["id"];
        if(isset($datos["post_id"])){$this->post_id = $datos["post_id"];}
        else{$this->post_id = $obtener["post_id"];};

        if(isset($datos["usuario_id"])){$this->usuario_id = $datos["usuario_id"];}
        else{$this->usuario_id = $obtener["usuario_id"];};

        if(isset($datos["comentario"])){$this->comentario = $datos["comentario"];}
        else{$this->comentario = $obtener["comentario"];};

        $headers = apache_request_headers();

         if(isset($headers['token'])){
            $token = $headers['token'];
              if(Auth::Check($token)){
                $query = "UPDATE " . $this->table . " SET post_id='".$this->post_id."', usuario_id='".$this->usuario_id."', comentario='".$this->comentario."', createdAt='".$this->createdAt."' WHERE id='".$this->id."'";
                $data=$conexion->nonQuery($query);
                return (($data>=1) ?  $data :  0);       
            }else
                  return 0;
        }else{
              return $_respuesta->error_200("Error en configuación del token. Contacte al Administrador");
        }
    }

    public function Eliminar($datos){
        $_respuesta = new respuestas;
        $conexion = new connection;    
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