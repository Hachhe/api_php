<?php

require_once 'class/controllers/categorias.controller.php';
require_once 'class/respuestas.php';

$_respuestas = new respuestas;

$_categorias = new CategoriasController;

// crud
if($_SERVER['REQUEST_METHOD'] == "GET"){
    //get por paginas
    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        header('Content-Type: application/json');    
        $lista_categorias = $_categorias->getAll($pagina);
        echo json_encode($lista_categorias);
        http_response_code(200);

    //get por id
    }else if(isset($_GET["id"])){
        $id = $_GET["id"];
        header('Content-Type: application/json');
        $categoria = $_categorias->getById($id);
        echo json_encode($categoria);
        http_response_code(200);
    }
    }else if($_SERVER['REQUEST_METHOD'] == "POST"){
        //recibir datos
        $body = file_get_contents('php://input');

        //send al manejador
        $datos = $_categorias->enviarCategorias($body);
    
        header('Content-Type: application/json');

        //enviamos
        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);
        

        print_r($datos);
    
        echo json_encode($datos);
    
    }else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        $body = file_get_contents('php://input');
        $datos = $_categorias->actualizarCategoria($body);
        header('Content-Type: application/json');

        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);

        print_r($datos);
    
        echo json_encode($datos);

    }else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
        $body = file_get_contents('php://input');
        $datos = $_categoria->Eliminar($body);
        header('Content-Type: application/json');

        http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);

        print_r($datos);

        echo json_encode($datos);
}else{
    header('Content-Type: application/json');
    $datos = $resp->error_405();
    echo json_encode($datos);
}