<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/RelatoriosEstoqueDao.php");
class RelatoriosEstoqueModel extends BaseModel{

    function RelatoriosEstoqueModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarHistoricoEstoque(){
        $dao = new RelatoriosEstoqueDao();
        $lista = $dao->ListarHistoricoEstoque($_SESSION['cod_cliente_final']);
        $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_MOVIMENTACAO', true);
        return json_encode($lista);
    }

    Public Function ListarProdutosMaisVendidos(){
        $dao = new RelatoriosEstoqueDao();
        $lista = $dao->ListarProdutosMaisVendidos($_SESSION['cod_cliente_final']);        
        return json_encode($lista);
    }

    /**
     *
     * @return <type>
     */
    function PesquisaProdutoEstoque(){
        $dao = new RelatoriosEstoqueDao();
        $listaEstoque = $dao->ListarEstoque($_SESSION['cod_cliente_final'], $_POST['parametro']);
        $listaProdutosEstoque = $dao->ListarEntradasEstoque($_SESSION['cod_cliente_final'], $_POST['parametro']);
        if ($listaProdutosEstoque[0]){
            $listaProdutosEstoque = BaseModel::FormataMoedaInArray($listaProdutosEstoque, 'VLR_UNITARIO|VLR_MINIMO|VLR_VENDA');
            $listaProdutosEstoque = BaseModel::AtualizaDataInArray($listaProdutosEstoque, 'DTA_ENTRADA');
        }
        $data = array();
        $data[] = array(
            'listaEstoque' => $listaEstoque,
            'listaProdutosEstoque' => $listaProdutosEstoque);

        return json_encode($data);
    }


    function ListarEstoque(){
        $dao = new RelatoriosEstoqueDao();
        $listaEstoque = $dao->ListarEstoque($_SESSION['cod_cliente_final']);
        $listaEntradasEstoque = $dao->ListarEntradasEstoque($_SESSION['cod_cliente_final']);
        $listaEntradasEstoque = BaseModel::AtualizaDataInArray($listaEntradasEstoque, 'DTA_ENTRADA');
        $data = array();
        $data[] = array('listaEstoque' => $listaEstoque,
                        'listaEntradasEstoque' => $listaEntradasEstoque);
        return json_encode($data);
    }

    Public Function ListarEstoqueProduto(){
        $dao = new RelatoriosEstoqueDao();
        $lista = $dao->ListarEstoqueProduto($_SESSION['cod_cliente_final']);
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_MINIMO|VLR_PRODUTO');
        return json_encode($lista);
    }
}
?>
