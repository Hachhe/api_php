<?php 

require_once './class/connection/connection.php';


class AuthModel{

    private $email;
    private $password;

    function __construct(){
    } 

    public function login( $data ){

        $this->email = $data['email'];
        $this->password = $data['password'];

        $connection = new Connection();
        $resp = new Respuestas;
        
        $query = "SELECT * FROM usuarios WHERE email = '$this->email'";
        
        $data = $connection->obtenerDatos($query);


        return (isset($data[0]['id'])) ? $data[0] : 0;

    }
}


