<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Vendas/FormaPagamentoVendasDao.php");
include_once("../../Model/Nfe/NfeModel.php");
include_once("../../Model/VendaReferencia/VendaReferenciaModel.php");
include_once("../../Model/EntradaEstoque/EntradaEstoqueModel.php");
include_once("../../Model/EntradaEstoque/EntradaEstoqueProdutoModel.php");
include_once("../../Model/EntradaEstoque/EntradaEstoquePagamentosModel.php");
class FormaPagamentoVendasModel extends BaseModel
{
    function FormaPagamentoVendasModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    function ListarTipoPagamento($Json=true){
        $dao = new FormaPagamentoVendasDao();
        $lista = $dao->ListarTipoPagamento();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    function ListarPagamentosVendas(){
        $dao = new FormaPagamentoVendasDao();
        $lista = $dao->ListarPagamentosVendas();
        $total = count($lista);
        $i=0;
        while($i<$total) {
            $lista[$i]['DTA_PAGAMENTO'] = $this->ConverteDataBanco($lista[$i]['DTA_PAGAMENTO']);
            $lista[$i]['VLR_PAGAMENTO'] = number_format($lista[$i]['VLR_PAGAMENTO'],2,'.',',');
            $i++;
        }
        return $lista;
    }
    
    function ListarPagamentosVendasGrid($Json=true){
        $dao = new FormaPagamentoVendasDao();
        $lista = $dao->ListarPagamentosVendas();
        if ($lista[0]){
            $vlrTotal = 0; 
            for ($i=0;$i<count($lista[1]);$i++){
                $vlrTotal = $lista[1][$i]['VLR_PAGAMENTO']+$vlrTotal;
            }
            $lista[2]['VLR_TOTAL'] = number_format($vlrTotal,2,",",".");
        }
        $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO');
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    function InserirPagamento($Json=true){
        $dao = new FormaPagamentoVendasDao();
        $dao->IniciaTransacao();
        if (filter_input(INPUT_POST, 'nroStatusVenda', FILTER_SANITIZE_STRING) == 'A'){
            $retorno[0] = true;
            $codTipoPagamento = filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT);
            $qtdParcelas = filter_input(INPUT_POST, 'qtdParcelas', FILTER_SANITIZE_NUMBER_INT);
            $dtaPagamento = filter_input(INPUT_POST, 'dtaPagamento', FILTER_SANITIZE_STRING);
            $nroSequencial=NULL;
            if (($codTipoPagamento==3)||($codTipoPagamento==6)){
                $data = $this->makeDate($dtaPagamento, 0, 1);
                $dtaPagamento = $data;
            }else if ($codTipoPagamento==5){
                $retorno = $this->InserirMercadoriaEstoque($dao);
                $nroSequencial=$retorno[2];
            }  
            if ($retorno[0]){
                if ($qtdParcelas>1){
                    for($i=0;$i<$qtdParcelas;$i++){
                        $retorno =$dao->InserirPagamento($_SESSION['cod_usuario'], $dtaPagamento, $nroSequencial);
                        if(!$retorno[0]){
                            exit;
                        }else{
                            $nroSequencial = $retorno[2];
                            $vlrPagamento = str_replace(",", "", filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING));
                            $retorno = $dao->RegistroOperacao($_SESSION['cod_usuario'], $dao->Populate('codVenda','I'), $vlrPagamento, $nroSequencial, $codTipoPagamento, 'I');
                        }
                        $data = $this->makeDate($dtaPagamento, 0, 1);
                        $dtaPagamento = $data;
                    }
                }else{              
                    $retorno = $dao->InserirPagamento($_SESSION['cod_usuario'], $dtaPagamento, $nroSequencial);
                    if($retorno[0]){
                        $nroSequencial = $retorno[2];
                        $vlrPagamento = str_replace(",", "", filter_input(INPUT_POST, 'vlrPagamento', FILTER_SANITIZE_STRING));
                        $retorno = $dao->RegistroOperacao($_SESSION['cod_usuario'], $dao->Populate('codVenda','I'), $vlrPagamento, $nroSequencial, $codTipoPagamento, 'I');
                    }
                }
            }
        }else{
            $retorno[0] = true;
            $retorno[1] = '';
        }
        if ($retorno[0]){
            $retorno[2] = $nroSequencial;
            $dao->ComitaTransacao();
        }else{
            $dao->RolbackTransacao();
        }
        if ($Json){
            return json_encode($retorno);
        }else{
            return $retorno;
        }
    }

    Public Function InserirMercadoriaEstoque($dao){
        $EntradaEstoqueModel = new EntradaEstoqueModel();
        $EntradaEstoqueProdutoModel = new EntradaEstoqueProdutoModel();
        $entradaEstoquePagamentosModel = new EntradaEstoquePagamentosModel();
        $nroNotaFiscal='V'.$dao->Populate('codVenda');
        $dtaEntrada='NOW()';
        $codFornecedor='0';
        $codDeposito=1;
        $txtObs="Mercadoria adquirida em venda para cliente.";
        $result = $EntradaEstoqueModel->AddEntradaEstoque(FALSE, $nroNotaFiscal, $dtaEntrada, $codFornecedor, $codDeposito, $txtObs);
        if ($result[0]){
            $nroSequencial = $result[2];
            $vlrCustoUnitario=$dao->Populate('vlrPagamento')/$dao->Populate('qtdMercadoria');
            $vlrMinimo=number_format($vlrCustoUnitario+($vlrCustoUnitario*0.25),2,',','.');
            $vlrVenda=number_format($vlrCustoUnitario+($vlrCustoUnitario*0.35),2,',','.');
            $qtdEntrada=$dao->Populate('qtdMercadoria');
            $result = $EntradaEstoqueProdutoModel->InserirProduto(FALSE, $nroSequencial, $dao->Populate('codMercadoriaVenda'), $vlrCustoUnitario, $vlrMinimo, $vlrVenda, $qtdEntrada);      
            if ($result[0]){
                $result = $entradaEstoquePagamentosModel->FecharEntrada(FALSE, $nroSequencial); 
                $result[2] = $nroSequencial;
            }
        }
        return $result;
    }
    
    function DeletarPagamentoVenda($Json=true){
        $dao = new FormaPagamentoVendasDao();
        $result = $this->VerificaPagamentoFechamentoCaixa($dao);
        $dao->IniciaTransacao();
        if ($result[0]){
            $result = $dao->RecuperaPagamentoVenda();
            if ($result[0]){
                $codVenda = $result[1][0]['COD_VENDA'];
                $codTipoPagamento = $result[1][0]['COD_TIPO_PAGAMENTO'];
                $vlrPagamento = $result[1][0]['VLR_PAGAMENTO'];
                if ($result[1][0]['COD_TIPO_PAGAMENTO']==5){
                    $nroSequencialEntrada = $result[1][0]['NRO_SEQUENCIAL_ENTRADA'];
                    $codProduto = $result[1][0]['COD_PRODUTO'];
                    $qtdEntrada = $result[1][0]['QTD_ENTRADA'];
                    $codVenda = $result[1][0]['COD_VENDA'];
                    $result = $this->BaixarEstoque($codVenda, $nroSequencialEntrada, $codProduto, $qtdEntrada);
                }
                if ($result[0]){
                    $result = $dao->DeletarPagamentoVenda();
                    if($result[0]){
                        $result = $dao->RegistroOperacao($_SESSION['cod_usuario'], $codVenda, $vlrPagamento, $dao->Populate('nroSequencialVenda','I'), $codTipoPagamento, 'D');
                    }
                }
            }
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

    Public Function VerificaPagamentoFechamentoCaixa(FormaPagamentoVendasDao $FormaPagamentoVendaDao){
        $result = $FormaPagamentoVendaDao->VerificaPagamentoFechamentoCaixa();
        if ($result[0]){
            if ($result[1][0]['QTD']>0){
                $result[0]=false;
                $result[1]='Este pagamento n&atilde;o pode ser removido por já constar em um fechamento de caixa!';
            }
        }
        return $result;
    }
    
    Public Function BaixarEstoque($codVenda, $nroSequencialEntrada, $codProduto, $qtdEntrada){
        $EntradaEstoqueProdutoModel = new EntradaEstoqueProdutoModel();
        $txtBaixa='Mercadoria Removida dos pagamentos da venda '.$codVenda;
        $result = $EntradaEstoqueProdutoModel->BaixaEstoque($nroSequencialEntrada, $codProduto, $qtdEntrada, $txtBaixa);
        return $result;
    }
    
    Public Function FecharVenda(){
        $dao = new FormaPagamentoVendasDao();
        $vendasDao = new VendasDao();
        $dao->IniciaTransacao();
//        if ($dao->Populate('indEmiteNota')=='S'){
//            $produtosVenda = $dao->VerificaProdutosVenda();
//            $result[0]=true;
//            if ($produtosVenda[1][0]['QTD']>0){
//                $result = static::EmitirNotaVendaMercadoria();
//            }
//            if ($result[0] || ($result[2]==400)){
//                $result = $dao->FecharVenda($_SESSION['cod_usuario']);
//            }
//        }else{
            $result = $dao->FecharVenda($_SESSION['cod_usuario']);
//        }
        if ($result[0]){
            $result = $vendasDao->RegistroVendaInsert($_SESSION['cod_usuario'], 'F', $dao->Populate('codVenda', 'I'));
        }
        if ($result[0]){                        
            $dao->ComitaTransacao();
        }else{
            $dao->RolbackTransacao();
        }   
        return json_encode($result);
    }  
    
    Public Function makeDate($date, $days=0, $mounths=0, $years=0){
        $date = explode("/", $date);
        return date('d/m/Y', mktime(0, 0, 0, $date[1] + $mounths, $date[0] +  $days, $date[2] + $years) );
    }

    Public Function VerificaValoresAbaixoMinimo($Json=true){
        $dao = new FormaPagamentoVendasDao();
        $lista = $dao->VerificaValoresAbaixoMinimo($_SESSION['cod_usuario']);
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }
}
?>
