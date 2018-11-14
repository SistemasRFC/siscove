<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/ComissaoVendedoresDao.php");
class ComissaoVendedoresModel extends BaseModel
{
    Public Function ComissaoVendedoresModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function DadosComissao(){
        $dao = new ComissaoVendedoresDao();
        $lista = $dao->DadosComissao($_SESSION['cod_cliente_final']);        
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENDA');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_VENDA_TOTAL|VLR_PORCENTAGEM_VENDA|VLR_PORCENTAGEM_VENDA_TOTAL');
        }
        return json_encode($lista);
    }

}
?>
