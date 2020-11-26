<?php

require_once './class/models/page.model.php';
require_once './utils/encript.php';

class PageController {

    public function getPrincipalData(){
        $resp = new Respuestas;

        $model = new PageModel;
        $data = $model->principalInformation();

        if(!isset($data) || $data != 0){
            return $resp->error_200("no hay datos registrados");
        }

        return $data;
    }

    public function getProducts($page = 1,$limit = 10){
        $resp = new Respuestas;

        $model = new PageModel;
        $data = $model->products($page,$limit);

        if(!isset($data) || $data == 0){
            return $resp->error_200("no hay datos registrados");
        }

        return $data;
    }
    
    public function getProductsRandom(){
        $resp = new Respuestas;

        $model = new PageModel;
        $data = $model->productsRandom();

        if(!isset($data) || $data == 0){
            return $resp->error_200("no hay datos registrados");
        }

        return $data;
    }

    public function getSocialNetworks(){
        $resp = new Respuestas;

        $model = new PageModel;
        $data = $model->socialNetworks();

        if(!isset($data) || $data == 0){
            return $resp->error_200("no hay datos registrados");
        }

        return $data;
    }
}

