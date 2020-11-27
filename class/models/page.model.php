<?php 

require_once './class/connection/connection.php';

class PageModel{


    public function principalInformation(){
        $connection = new Connection();
        
        $query = "SELECT * FROM posts";

        $data = $connection->obtenerDatos($query);

        return (isset($data[0]['posts'])) ? $data[0] : 0;
    }

}


