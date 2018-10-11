<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/CofinsSituacaoTributaria/CofinsSituacaoTributariaDao.php");
class CofinsSituacaoTributariaModel extends BaseModel
{
    public function CofinsSituacaoTributariaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarCofinsSituacaoTributaria($Json=true){
        $dao = new CofinsSituacaoTributariaDao();
        $lista = $dao->ListarCofinsSituacaoTributaria();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertCofinsSituacaoTributaria(){
        $dao = new CofinsSituacaoTributariaDao();        
        $result = $dao->InsertCofinsSituacaoTributaria();
        return json_encode($result);        
    }

    Public Function UpdateCofinsSituacaoTributaria(){
        $dao = new CofinsSituacaoTributariaDao();
        $result = $dao->UpdateCofinsSituacaoTributaria();
        return json_encode($result);
    }	
    
}

