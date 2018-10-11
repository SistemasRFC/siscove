<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Cfop/CfopDao.php");
class CfopModel extends BaseModel
{
    public function CfopModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarCfop($Json=true){
        $dao = new CfopDao();
        $lista = $dao->ListarCfop();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertCfop(){
        $dao = new CfopDao();        
        $result = $dao->InsertCfop();
        return json_encode($result);        
    }

    Public Function UpdateCfop(){
        $dao = new CfopDao();
        $result = $dao->UpdateCfop();
        return json_encode($result);
    }	
    
}

