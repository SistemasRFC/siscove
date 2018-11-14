<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/ComissaoFuncionariosDao.php");
class ComissaoFuncionariosModel extends BaseModel
{
    Public Function ComissaoFuncionariosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function DadosComissao(){
        $dao = new ComissaoFuncionariosDao();
        $lista = $dao->DadosComissao($_SESSION['cod_cliente_final']);
        $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENDA');
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_VENDA_TOTAL|VLR_PORCENTAGEM_VENDA_TOTAL|VLR_PORCENTAGEM_VENDA');
        return json_encode($lista);
    }

}
?>
