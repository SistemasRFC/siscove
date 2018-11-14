<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Orcamentos/ProdutosOrcamentosDao.php");
class ProdutosOrcamentosModel extends BaseModel
{
    Public Function ProdutosOrcamentosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }
    
    Public Function ListarDadosProdutosVenda($Json=true){
        $dao = new ProdutosOrcamentosDao();
        $lista = $dao->ListarDadosProdutosVenda();
        for($i=0;$i<count($lista[1]);$i++){
            $lista[1][$i]['VLR_SOMA'] = ($lista[1][$i]['VLR_VENDA']-$lista[1][$i]['VLR_DESCONTO'])*$lista[1][$i]['QTD_VENDIDA'];
            $lista[1][$i]['VLR_SOMA_LABEL'] = ($lista[1][$i]['VLR_VENDA']-$lista[1][$i]['VLR_DESCONTO'])*$lista[1][$i]['QTD_VENDIDA'];
        }     
        $lista = BaseModel::FormataMoedaInArray($lista, "VLR_SOMA|VLR_VENDA|VLR_DESCONTO");
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }

    }
    
    Public Function InserirProduto($Json=true){
        $dao = new ProdutosOrcamentosDao();
        $result = $dao->InserirProduto();
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }
    }

    Public Function DeletarProdutoVenda($Json=true){
        $dao = new ProdutosOrcamentosDao();
        $result = $dao->DeletarProdutoVenda();
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }
    }

    /**
     * Retorna uma lista de produtos de uma determinada venda
     * @return Array
     */
    Public Function ListarProdutosVenda(){
        $dao = new ProdutosOrcamentosDao();
        $lista = $dao->ListarProdutosVenda();                    
        return $lista;
    }
}
?>
