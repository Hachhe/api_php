<?php

require_once './class/respuestas.php';
require './class/controllers/auth.controller.php';

$authController = new AuthController;

$resp = new Respuestas;

if($_SERVER['REQUEST_METHOD'] == "POST"){

    //recibir datos
    $body = file_get_contents('php://input');

    //send al manejador
    $datos = $authController->login($body);

    header('Content-Type: application/json');

    http_response_code(isset($datos['result']['error_id']) ? $datos['result']['error_id'] : 200);
    
    echo json_encode($datos);
}else {
    header('Content-Type: application/json');
    $datos = $resp->error_405();
    echo json_encode($datos);
}