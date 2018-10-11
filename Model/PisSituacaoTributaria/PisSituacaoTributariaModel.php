<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/PisSituacaoTributaria/PisSituacaoTributariaDao.php");
class PisSituacaoTributariaModel extends BaseModel
{
    public function PisSituacaoTributariaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarPisSituacaoTributaria($Json=true){
        $dao = new PisSituacaoTributariaDao();
        $lista = $dao->ListarPisSituacaoTributaria();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertPisSituacaoTributaria(){
        $dao = new PisSituacaoTributariaDao();        
        $result = $dao->InsertPisSituacaoTributaria();
        return json_encode($result);        
    }

    Public Function UpdatePisSituacaoTributaria(){
        $dao = new PisSituacaoTributariaDao();
        $result = $dao->UpdatePisSituacaoTributaria();
        return json_encode($result);
    }	
    
}

