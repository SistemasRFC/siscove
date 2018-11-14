<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Ncm/NcmDao.php");
class NcmModel extends BaseModel
{
    public function NcmModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarNcm($Json=true){
        $dao = new NcmDao();
        $lista = $dao->ListarNcm();
        $lista[1] = BaseModel::utf8_converter($lista[1]);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertNcm(){
        $dao = new NcmDao();        
        $result = $dao->InsertNcm();
        return json_encode($result);        
    }

    Public Function UpdateNcm(){
        $dao = new NcmDao();
        $result = $dao->UpdateNcm();
        return json_encode($result);
    }	
    
}

