<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once './class/models/auth.model.php';
require_once './class/models/usuarios.model.php';

class UsuariosController extends Connection{

    public function getAll($pagina = 1){
        $_respuesta = new respuestas;
        $inicio = 0;
        $cantidad = 10;
        if($pagina>1){
            $inicio = ($cantidad * ($pagina-1))+1;
            $cantidad = $cantidad * $pagina;
        }

        $_UsuarioModel = new UsuarioModel;

        $data = $_UsuarioModel->getAll($inicio,$cantidad);

        if(!isset($data) || $data == 0){
            return $_respuesta->error_200("no hay datos registrados");
        }
        
        return $data;

    }
    public function getById($id){
        $_respuesta = new respuestas;
        $_UsuarioModel = new UsuarioModel;
        $data = $_UsuarioModel->getById($id);
        if(!isset($data) || $data == 0){
            return $_respuesta->error_200("no hay datos registrados");
        }
        return $data;

    }

    public function enviarUsuario($json){
        $_respuesta = new respuestas;
        $_UsuarioModel = new UsuarioModel;
        $datos = json_decode($json, true);
        if(!isset($datos["nombre"])||
        !isset($datos["apellido"])||
        !isset($datos["email"])||
        !isset($datos["password"])||
        !isset($datos["rol_id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_UsuarioModel->Enviar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $nuevo);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }
    }

    public function actualizarUsuario($json){
        $_respuesta = new respuestas;
        $_UsuarioModel = new UsuarioModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_UsuarioModel->Actualizar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $datos['id']);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }

    }

    public function Eliminar($json){
        $_respuesta = new respuestas;
        $_UsuarioModel = new UsuarioModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_UsuarioModel->Eliminar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $datos['id']);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }

    }

}