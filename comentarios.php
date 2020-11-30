<?php

require_once 'class/controllers/comentarios.controller.php';
require_once 'class/respuestas.php';

$_respuestas = new respuestas;

$_comentarios = new ComentariosController;

// crud
if($_SERVER['REQUEST_METHOD'] == "GET"){
    //get por paginas
    if(isset($_GET["page"])){
        $limit= isset($_GET["limit"]) ? $_GET["limit"] : 10;
        $pagina = $_GET["page"];
        header('Content-Type: application/json');    
        $listarComentarios = $_comentarios->getAll($pagina,$limit);
        echo json_encode($listarComentarios);
        http_response_code(200);

    //get por id
    }else if(isset($_GET["id"])){
        $id = $_GET["id"];
        header('Content-Type: application/json');
        $comentario = $_comentarios->getById($id);
        echo json_encode($comentario);
        http_response_code(200);
    }
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        //recibir datos
        $body = file_get_contents('php://input');

        //send al manejador
        $datos = $_comentarios->enviarComentario($body);
    
        header('Content-Type: application/json');

        //enviamos
        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);
        

        print_r($datos);
    
        echo json_encode($datos);
    
    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        $body = file_get_contents('php://input');
        $datos = $_comentarios->actualizarComentario($body);
        header('Content-Type: application/json');

        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);

        print_r($datos);
    
        echo json_encode($datos);

    }else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $body = file_get_contents('php://input');
        $datos = $_comentarios->Eliminar($body);
        header('Content-Type: application/json');

        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);

        print_r($datos);

        echo json_encode($datos);
}else{
    header('Content-Type: application/json');
    $datos = $resp->error_405();
    echo json_encode($datos);
}