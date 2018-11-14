<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/EntradaEstoque/EntradaEstoquePagamentosDao.php");
include_once("../../Dao/EntradaEstoque/EntradaEstoqueProdutoDao.php");
class EntradaEstoquePagamentosModel extends BaseModel
{
    Public Function EntradaEstoquePagamentosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function ListarPagamentosEntradas($Json=true){
        $dao = new EntradaEstoquePagamentosDao();
        $lista = $dao->ListarPagamentosEntradas();
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
        }        
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function ListarChequesRecebidos($Json=true){
        $dao = new EntradaEstoquePagamentosDao();
        $lista = $dao->ListarChequesRecebidos($_SESSION['cod_cliente_final']);
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
    Public Function InserirPagamento($Json=true){
        $dao = new EntradaEstoquePagamentosDao();
        $lista = $dao->InserirPagamento();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function DeletarPagamentoEntrada($Json=true){
        $dao = new EntradaEstoquePagamentosDao();
        $lista = $dao->DeletarPagamentoEntrada();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    Public Function FecharEntrada($Json=true, $nroSequencial=NULL){
        $dao = new EntradaEstoquePagamentosDao();
        $produtosDao = new EntradaEstoqueProdutoDao();
        $lista = $dao->FecharEntrada($nroSequencial);
        if ($lista[0]){
            $listaProdutos = $produtosDao->ListarDadosProdutosEntrada($nroSequencial);
            if ($listaProdutos[0]){
                for ($i=0;$i<count($listaProdutos[1]);$i++){
                    $produtosDao->AtualizaEstoque('ADD', 
                                                  $listaProdutos[1][$i]['QTD_ENTRADA'], 
                                                  $listaProdutos[1][$i]['COD_PRODUTO'], 
                                                  $listaProdutos[1][$i]['NRO_SEQUENCIAL']);  
                }
            }
        }
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
}
?>
