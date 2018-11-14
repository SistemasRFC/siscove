<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Vendas/ProdutosVendasDao.php");
class ProdutosVendasModel extends BaseModel
{
    Public Function ProdutosVendasModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }
    
    Public Function ListarDadosProdutosVenda($Json=true){
        $dao = new ProdutosVendasDao();
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
        $dao = new ProdutosVendasDao();
        $dao->IniciaTransacao();
        if (filter_input(INPUT_POST, 'nroStatusVenda', FILTER_SANITIZE_STRING) == 'A'){
            $result = $dao->RegistroProdutoVenda($_SESSION['cod_usuario'], 'I');
            if ($result[0]){
                $result = $dao->InserirProduto();
                //$result[0]=true;
                if (filter_input(INPUT_POST, 'indEstoqueVenda', FILTER_SANITIZE_STRING)=="S"){
                    $result = $dao->AtualizaEstoque("REMOVE",
                                          filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_NUMBER_INT),
                                          filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT),
                                          filter_input(INPUT_POST, 'qtdVenda', FILTER_SANITIZE_NUMBER_INT));
                }
            }
        }else{
            $result[0] = true;
            $result[1] = '';
        }
        if ($result[0]){                        
            $dao->ComitaTransacao();
        }else{
            $dao->RolbackTransacao();
        }
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }
    }

    Public Function DeletarProdutoVenda($Json=true){
        $dao = new ProdutosVendasDao();
        $dao->IniciaTransacao();
        if (filter_input(INPUT_POST, 'nroStatusVenda', FILTER_SANITIZE_STRING) == 'A'){
            $result = $dao->RegistroProdutoVenda($_SESSION['cod_usuario'],'D');
            if ($result[0]){
                $result = $dao->DeletarProdutoVenda();
                if (filter_input(INPUT_POST, 'indEstoqueVenda', FILTER_SANITIZE_STRING)=="S"){
                    $result = $dao->AtualizaEstoque("ADD",
                                          filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_STRING),
                                          filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_STRING),
                                          filter_input(INPUT_POST, 'qtdVenda', FILTER_SANITIZE_STRING));
                }
            }
        }else{
            $result[0] = true;
            $result[1] = '';
        }
        if ($result[0]){                        
            $dao->ComitaTransacao();
        }else{
            $dao->RolbackTransacao();
        }
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
        $dao = new ProdutosVendasDao();
        $lista = $dao->ListarProdutosVenda();                    
        return $lista;
    }

    Public Function ListarProdutosVendasGrid(){
        $dao = new ProdutosVendasDao();
        $lista = $dao->ListarProdutosVenda();
        $total = count($lista);
        $i=0;
        $data = array();
        $vlrTotalVenda = 0;
        while($i<$total ) {
            $vlrTotalVenda = $vlrTotalVenda+(($lista[$i]['VLR_VENDA']-$lista[$i]['VLR_DESCONTO'])*$lista[$i]['QTD_VENDIDA']);
            $i++;
        }
        $i=0;
        while($i<$total ) {
            $data[] = array(
                'dscProduto' => $lista[$i]['DSC_PRODUTO'],
                'codProduto' => $lista[$i]['COD_PRODUTO'],
                'nmeVendedor' => $lista[$i]['NME_FUNCIONARIO'],
                'qtdVenda' => $lista[$i]['QTD_VENDIDA'],
                'vlrVenda' => number_format($lista[$i]['VLR_VENDA'],2,',','.'),
                'vlrDesconto' => number_format($lista[$i]['VLR_DESCONTO'],2,',','.'),
                'nroSequencialVenda' => $lista[$i]['NRO_SEQUENCIAL'],
                'codVenda' => $lista[$i]['COD_VENDA'],
                'indEstoque' => $lista[$i]['IND_ESTOQUE'],
                'nroStatusVenda' => $lista[$i]['NRO_STATUS_VENDA'],
                'vlrTotal' => number_format((($lista[$i]['VLR_VENDA']-$lista[$i]['VLR_DESCONTO'])*$lista[$i]['QTD_VENDIDA']),2,',','.'),
                'vlrTotalVenda' => number_format($vlrTotalVenda,2,',','.'),
                'qtdEstoque' => $lista[$i]['QTD_ESTOQUE'],
                'nroSequencial' => $lista[$i]['NRO_SEQUENCIAL']
            );
            $i++;
        }
        return json_encode($data);
    }
}
?>
