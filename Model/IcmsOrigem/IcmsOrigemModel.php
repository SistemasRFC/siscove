<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/IcmsOrigem/IcmsOrigemDao.php");
class IcmsOrigemModel extends BaseModel
{
    public function IcmsOrigemModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarIcmsOrigem($Json=true){
        $dao = new IcmsOrigemDao();
        $lista = $dao->ListarIcmsOrigem();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertIcmsOrigem(){
        $dao = new IcmsOrigemDao();        
        $result = $dao->InsertIcmsOrigem();
        return json_encode($result);        
    }

    Public Function UpdateIcmsOrigem(){
        $dao = new IcmsOrigemDao();
        $result = $dao->UpdateIcmsOrigem();
        return json_encode($result);
    }	
    
}

