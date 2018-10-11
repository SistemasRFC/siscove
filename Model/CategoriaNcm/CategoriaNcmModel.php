<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/CategoriaNcm/CategoriaNcmDao.php");
class CategoriaNcmModel extends BaseModel
{
    public function CategoriaNcmModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarCategoriaNcm($Json=true){
        $dao = new CategoriaNcmDao();
        $lista = $dao->ListarCategoriaNcm();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertCategoriaNcm(){
        $dao = new CategoriaNcmDao();        
        $result = $dao->InsertCategoriaNcm();
        return json_encode($result);        
    }

    Public Function UpdateCategoriaNcm(){
        $dao = new CategoriaNcmDao();
        $result = $dao->UpdateCategoriaNcm();
        return json_encode($result);
    }	
    
}

