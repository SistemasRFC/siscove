<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Campeonato/CampeonatoDao.php");
class CampeonatoModel extends BaseModel
{
    public function CampeonatoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarCampeonato($Json=true){
        $dao = new CampeonatoDao();
        $lista = $dao->ListarCampeonato($_SESSION['cod_loja']);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertCampeonato(){
        $dao = new CampeonatoDao();        
        $result = $dao->InsertCampeonato($_SESSION['cod_loja']);
        return json_encode($result);        
    }

    Public Function UpdateCampeonato(){
        $dao = new CampeonatoDao();
        $result = $dao->UpdateCampeonato();
        return json_encode($result);
    }	
    
}

