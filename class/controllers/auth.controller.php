<?php

require_once './class/models/auth.model.php';
require_once './utils/encript.php';
require_once 'auth.clase.php';

class AuthController {

    public function login($json){
        $resp = new Respuestas;
        $data = json_decode($json, true);

        if(!isset($data['email']) || !isset($data['password'])){
            return $resp->error_400();
        }

        $model = new AuthModel();
        $dataUserLogin = $model->login($data);

        if(!isset($dataUserLogin['email'])){
            return $resp->error_200("No existe usuario con correo: ".$data['email']);
        }
        if(!((encriptar($data['password'])) == $dataUserLogin['password'])){
            return $resp->error_200("Las credenciales no coinciden");
        }

        $token  = Auth::SignIn($dataUserLogin);

        if($token){
            $result = $resp->response;
            $result['result']= array(
                "token" => $token
            );
            return $result;
        }{
            return $resp->error_500("Error interno, token no guardado");
        }
    }
}


