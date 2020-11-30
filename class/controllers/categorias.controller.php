<?php
require_once 'class/connection/connection.php';
require_once 'class/respuestas.php';
require_once './class/models/auth.model.php';
require_once './class/models/categorias.model.php';

class CategoriasController extends Connection{

    public function getAll($pagina=1, $cantidad=10){
        $_respuesta = new respuestas;
        $_CategoriaModel = new CategoriaModel;
        $data = $_CategoriaModel->getAll($pagina,$cantidad);

        if(!isset($data) || $data == 0){
            return $data = [];
        }
        
        return $data;

    }
    public function getById($id){
        $_respuesta = new respuestas;
        $_CategoriaModel = new CategoriaModel;
        $data = $_CategoriaModel->getById($id);
        if(!isset($data) || $data == 0){
            return $_respuesta->error_200("no hay datos registrados");
        }
        return $data;

    }

    public function enviarCategoria($json){
        $_respuesta = new respuestas;
        $_CategoriaModel = new CategoriaModel;
        $datos = json_decode($json, true);
        if(!isset($datos["categoria"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $CategoriaModel->Enviar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $nuevo);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }
    }

    public function actualizarCategoria($json){
        $_respuesta = new respuestas;
        $_CategoriaModel = new CategoriaModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_CategoriaModel->Actualizar($datos);
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
        $_CategoriaModel = new CategoriaModel;
        $datos = json_decode($json, true);
        if(!isset($datos["id"])){
            return $_respuesta->error_400();
        }else{
            $nuevo = $_CategoriaModel->Eliminar($datos);
        }if($nuevo){
            $respuesta = $_respuesta->response;
            $respuesta["result"] =  array('id'=> $datos['id']);
            return $respuesta;
        }else{
            return $_respuesta->error_500();
        }

    }

}