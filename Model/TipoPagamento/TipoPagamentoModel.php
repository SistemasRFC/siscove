<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/TipoPagamento/TipoPagamentoDao.php");
class TipoPagamentoModel extends BaseModel
{
    Public Function TipoPagamentoModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        } 
    }
    
    Public Function ListarTipoPagamento($Json=true){
        $dao = new TipoPagamentoDao();
        $lista = $dao->ListarTipoPagamento($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            for($i=0;$i<count($lista[1]);$i++){
                $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_ATIVO', 'ATIVO');
            }
        }
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
    
    Public Function ListarTipoPagamentoAtivo($Json=true){
        $dao = new TipoPagamentoDao();
        $lista = $dao->ListarTipoPagamentoAtivo($_SESSION['cod_cliente_final']);
        if($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }        
        
    }
    
    Public Function AddTipoPagamento(){
        $dao = new TipoPagamentoDao();
        return json_encode($dao->AddTipoPagamento($_SESSION['cod_cliente_final']));
    }

    Public Function UpdateTipoPagamento(){
        $dao = new TipoPagamentoDao();
        return json_encode($dao->UpdateTipoPagamento());
    }
}
?>
