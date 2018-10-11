<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/ComissaoFuncionariosQtdProdutosDao.php");
class ComissaoFuncionariosQtdProdutosModel extends BaseModel
{
    Public Function ComissaoFuncionariosQtdProdutosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function DadosComissao(){
        $dao = new ComissaoFuncionariosQtdProdutosDao();
        $lista = $dao->DadosComissao($_SESSION['cod_cliente_final']);
        $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENDA');
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_VENDA_TOTAL|VLR_DESCONTO|VLR_VENDA|VLR_VENDA_TOTAL_COM_DESCONTO');
        return json_encode($lista);
    }

}
?>
