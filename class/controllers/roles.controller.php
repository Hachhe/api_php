<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once './class/models/auth.model.php';
require_once './class/models/roles.model.php';

class RolesController extends Connection{

    public function getAll($pagina = 1){
        $_respuesta = new respuestas;
        $inicio = 0;
        $cantidad = 10;
        if($pagina>1){
            $inicio = ($cantidad * ($pagina-1))+1;
            $cantidad = $cantidad * $pagina;
        }

        $_RolModel = new RolModel;

        $data = $_RolModel->getAll($inicio,$cantidad);

        if(!isset($data) || $data == 0){
            return $_respuesta->error_200("no hay datos registrados");
        }
        
        return $data;

    }
    public function getById($id){
        $_respuesta = new respuestas;
        $_RolModel = new RolModel;
        $data = $_RolModel->getById($id);
        if(!isset($data) || $data == 0){
            return $_respuesta->error_200("no hay datos registrados");
        }
        return $data;

    }

    public function enviarRol($json){
        $_respuesta = new respuestas;
        $_RolModel = new RolModel;
        $datos = json_decode($json, true);
        if(!isset($datos["rol"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_RolModel->Enviar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $nuevo);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }
    }

    public function actualizarRol($json){
        $_respuesta = new respuestas;
        $_RolModel = new RolModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_RolModel->Actualizar($datos);
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
        $_RolModel = new RolModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_RolModel->Eliminar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $datos['id']);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }

    }

}