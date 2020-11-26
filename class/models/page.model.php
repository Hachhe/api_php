<?php 

require_once './class/connection/connection.php';

class PageModel{


    public function principalInformation(){
        $connection = new Connection();
        
        $query = "SELECT * FROM infostore";
        

        $data = $connection->obtenerDatos($query);

        return (isset($data[0]['nameStore'])) ? $data[0] : 0;
    }

    public function products($page , $limit ){
        $connection = new Connection();
        
        $query = "SELECT * FROM products LIMIT $limit OFFSET $page";
        

        $data = $connection->obtenerDatos($query);


        return (isset($data[0])) ? $data : 0;
        
    }
    
    public function productsRandom(){
        $connection = new Connection();
        
        $query = "SELECT * FROM products ORDER BY rand() LIMIT 3";
        

        $data = $connection->obtenerDatos($query);


        return (isset($data[0])) ? $data : 0;
        
    }

    public function socialNetworks(){
        $connection = new Connection();
        
        $query = "SELECT * FROM socialnetworks";
        

        $data = $connection->obtenerDatos($query);


        return (isset($data[0])) ? $data : 0;
        
    }
}


