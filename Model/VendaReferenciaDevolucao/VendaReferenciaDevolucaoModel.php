<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/VendaReferenciaDevolucao/VendaReferenciaDevolucaoDao.php");
class VendaReferenciaDevolucaoModel extends BaseModel
{
    public function VendaReferenciaDevolucaoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarVendaReferenciaDevolucao($Json=true){
        $dao = new VendaReferenciaDevolucaoDao();
        $lista = $dao->ListarVendaReferenciaDevolucao();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertVendaReferenciaDevolucao($Json=true){
        $dao = new VendaReferenciaDevolucaoDao();        
        $result = $dao->InsertVendaReferenciaDevolucao($_SESSION['cod_usuario']);
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }         
    }

    Public Function UpdateVendaReferenciaDevolucao($nroSequencial=NULL, $indStatus){
        $dao = new VendaReferenciaDevolucaoDao();
        if ($nroSequencial==NULL){
            $nroSequencial = $dao->Populate('nroSequencial');
        }
        $result = $dao->UpdateVendaReferenciaDevolucao($nroSequencial, $indStatus, $_SESSION['cod_usuario']);
        return json_encode($result);
    }
    
    Public Function RetornaVendaReferenciaDevolucao($Json=true){
        $dao = new VendaReferenciaDevolucaoDao();
        $lista = $dao->RetornaVendaReferenciaDevolucao();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }        
    }
    
    Public Function RetornaUltimaReferencia($Json=true){
        $dao = new VendaReferenciaDevolucaoDao();
        $lista = $dao->RetornaUltimaReferencia();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }        
    }
    
    Public Function RemoveVendaReferenciaDevolucao($Json=true, $nroSequencial=NULL){
        $dao = new VendaReferenciaDevolucaoDao();
        if ($nroSequencial==NULL){
            $nroSequencial = $dao->Populate('nroSequencial');
        }
        $result = $dao->RemoveReferencia($nroSequencial);
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }          
    }
    
}

