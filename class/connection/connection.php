<?php

class Connection{
     
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    function __construct(){
        $datos = $this->datosConexion()['conexion'];
        $this->server = $datos['server'];
        $this->user = $datos['user'];
        $this->password = $datos['password'];
        $this->database = $datos['database'];
        $this->port = $datos['port'];

        $this->conexion = new mysqli($this->server,$this->user,$this->password, $this->database, $this->port);
        if($this->conexion->connect_errno){
            echo "no se pudo conectar a la base de datos";
            die();
        }
    }

    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $json = file_get_contents($direccion."/"."config");
        return json_decode($json, true);
    }  

    private function convertirUTF8($array){
        array_walk_recursive($array,function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    public function obtenerDatos($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this->convertirUTF8($resultArray);

    }


    // para los updates
    public function nonQuery($sqlstr){
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }


    //para hacer INSERT 
    public function nonQueryId($sqlstr){
        $results = $this->conexion->query($sqlstr);
         $filas = $this->conexion->affected_rows;
         if($filas >= 1){
            return $this->conexion->insert_id;
         }else{
             return 0;
         }
    }
     
}
