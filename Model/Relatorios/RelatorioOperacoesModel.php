<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/RelatorioOperacoesDao.php");
class RelatorioOperacoesModel extends BaseModel{

    function RelatorioOperacoesModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarRegistrosVenda(){
        $dao = new RelatorioOperacoesDao();
        $RegistroVenda = $dao->ListarRegistrosVenda();
        $RegistroVenda = BaseModel::AtualizaDataInArray($RegistroVenda, 'DTA_OPERACAO', true);
        return $RegistroVenda;
    }
    
    Public Function ListarRegistrosProduto(){
        $dao = new RelatorioOperacoesDao();
        $registrosProduto = $dao->ListarRegistrosProduto();
        $registrosProduto = BaseModel::AtualizaDataInArray($registrosProduto, 'DTA_OPERACAO', true);
        $registrosProduto = BaseModel::FormataMoedaInArray($registrosProduto, 'VLR_PRODUTO');
        return $registrosProduto;
    }
    
    Public Function ListarRegistrosPagamento(){
        $dao = new RelatorioOperacoesDao();
        $registrosPagamento = $dao->ListarRegistrosPagamento();
        $registrosPagamento = BaseModel::AtualizaDataInArray($registrosPagamento, 'DTA_OPERACAO', true);
        $registrosPagamento = BaseModel::FormataMoedaInArray($registrosPagamento, 'VLR_PAGAMENTO');
        return $registrosPagamento;
    }
}
?>
