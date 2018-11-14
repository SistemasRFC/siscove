<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/RelatoriosClientesDao.php");
class RelatoriosClientesModel extends BaseModel
{
    function RelatoriosClientesModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Function DadosClientes(){
        $dao = new RelatoriosClientesDao();
        $dadosVenda = $dao->DadosCliente($_SESSION['cod_cliente_final']);
        return json_encode($dadosVenda);
    }

    Function DadosVendas(){
        $dao = new RelatoriosClientesDao();
        $dadosVenda = $dao->DadosVendas($_SESSION['cod_cliente_final']);
        for($i=0;$i<count($dadosVenda[1]);$i++){
            $dadosVenda[1][$i]['DTA_VENDA'] = $this->ConverteDataBanco($dadosVenda[1][$i]['DTA_VENDA']);
        }
        return $dadosVenda;
    }
}
?>
