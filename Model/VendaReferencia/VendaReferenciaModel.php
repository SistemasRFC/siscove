<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/VendaReferencia/VendaReferenciaDao.php");
class VendaReferenciaModel extends BaseModel
{
    public function VendaReferenciaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarVendaReferencia($Json=true){
        $dao = new VendaReferenciaDao();
        $lista = $dao->ListarVendaReferencia();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }
    }
    
    Public Function InsertVendaReferencia($Json=true){
        $dao = new VendaReferenciaDao();        
        $result = $dao->InsertVendaReferencia($_SESSION['cod_usuario']);
        if ($Json){
            return json_encode($result);
        }else{
            return $result;        
        }         
    }

    Public Function UpdateVendaReferencia($nroSequencial=NULL, $indStatus){
        $dao = new VendaReferenciaDao();
        if ($nroSequencial==NULL){
            $nroSequencial = $dao->Populate('nroSequencial');
        }
        $result = $dao->UpdateVendaReferencia($nroSequencial, $indStatus, $_SESSION['cod_usuario']);
        return json_encode($result);
    }
    
    Public Function RetornaVendaReferencia($Json=true){
        $dao = new VendaReferenciaDao();
        $lista = $dao->RetornaVendaReferencia();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }        
    }
    
    Public Function RetornaUltimaReferencia($Json=true){
        $dao = new VendaReferenciaDao();
        $lista = $dao->RetornaUltimaReferencia();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;        
        }        
    }
    
    Public Function RemoveVendaReferencia($Json=true, $nroSequencial=NULL){
        $dao = new VendaReferenciaDao();
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

