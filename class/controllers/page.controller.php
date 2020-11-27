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
    
}

