<?php

require_once 'class/controllers/posts.controller.php';
require_once 'class/respuestas.php';

$_respuestas = new respuestas;

$_post = new PostController;

// crud
if($_SERVER['REQUEST_METHOD'] == "GET"){
    //get por paginas
    if(isset($_GET["page"])){
        $limit= isset($_GET["limit"]) ? $_GET["limit"] : 10;
        $pagina = $_GET["page"];
        header('Content-Type: application/json');    
        $lista_posts = $_post->getAll($pagina,$limit);
        echo json_encode($lista_posts);
        http_response_code(200);

    //get por id
    }else if(isset($_GET["id"])){
        $id = $_GET["id"];
        header('Content-Type: application/json');
        $post = $_post->getById($id);
        echo json_encode($post);
        http_response_code(200);
    }
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        //recibir datos
        $body = file_get_contents('php://input');

        //send al manejador
        $datos = $_post->enviarPost($body);
    
        header('Content-Type: application/json');

        //enviamos
        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);
        

        print_r($datos);
    
        echo json_encode($datos);
    
    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        $body = file_get_contents('php://input');
        $datos = $_post->actualizarPost($body);
        header('Content-Type: application/json');

        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);

        print_r($datos);
    
        echo json_encode($datos);

    }else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $body = file_get_contents('php://input');
        $datos = $_post->Eliminar($body);
        header('Content-Type: application/json');

        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);

        print_r($datos);

        echo json_encode($datos);
}else{
    header('Content-Type: application/json');
    $datos = $resp->error_405();
    echo json_encode($datos);
}