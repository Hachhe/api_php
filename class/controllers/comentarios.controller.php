<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once './class/models/comentarios.model.php';
require_once './class/models/auth.model.php';

class ComentariosController extends Connection{

    public function getAll($pagina=1, $cantidad=10){
        $_respuesta = new respuestas;
        $_ComentarioModel = new ComentarioModel;

        $data = $_ComentarioModel->getAll($pagina,$cantidad);

        if(!isset($data) || $data == 0){
            return $data = [];
        }
        
        return $data;

    }
    public function getById($id){
        $_respuesta = new respuestas;
        $_ComentarioModel = new ComentarioModel;
        $data = $_ComentarioModel->getById($id);
        if(!isset($data) || $data == 0){
            return $_respuesta->error_200("no hay datos registrados");
        }
        return $data;

    }

    public function enviarComentario($json){
        $_respuesta = new respuestas;
        $_ComentarioModel = new ComentarioModel;
        $datos = json_decode($json, true);
        if(!isset($datos["post_id"])||
        !isset($datos["titulo"])||
        !isset($datos["descripcion"])||
        !isset($datos["estado"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_ComentarioModel->Enviar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $nuevo);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }
    }

    public function actualizarComentario($json){
        $_respuesta = new respuestas;
        $_ComentarioModel = new ComentarioModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_ComentarioModel->Actualizar($datos);
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
        $_ComentarioModel = new ComentarioModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_ComentarioModel->Eliminar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $datos['id']);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }

    }

}