<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/IcmsSituacaoTributaria/IcmsSituacaoTributariaDao.php");
class IcmsSituacaoTributariaModel extends BaseModel
{
    public function IcmsSituacaoTributariaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarIcmsSituacaoTributaria($Json=true){
        $dao = new IcmsSituacaoTributariaDao();
        $lista = $dao->ListarIcmsSituacaoTributaria();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertIcmsSituacaoTributaria(){
        $dao = new IcmsSituacaoTributariaDao();        
        $result = $dao->InsertIcmsSituacaoTributaria();
        return json_encode($result);        
    }

    Public Function UpdateIcmsSituacaoTributaria(){
        $dao = new IcmsSituacaoTributariaDao();
        $result = $dao->UpdateIcmsSituacaoTributaria();
        return json_encode($result);
    }	
    
}

