<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/RelatoriosVendasDao.php");
class RelatoriosVendasModel extends BaseModel
{
    Public Function RelatoriosVendasModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Public Function DadosVenda(){
        $dao = new RelatoriosVendasDao();
        $dadosVenda = $dao->DadosVenda($_SESSION['cod_cliente_final']);
        $dadosVenda[1][0]['DTA_VENDA'] = $this->ConverteDataBanco($dadosVenda[1][0]['DTA_VENDA']);
        return $dadosVenda;
    }

    Public Function DadosProdutosVenda(){
        $dao = new RelatoriosVendasDao();
        return $dao->DadosProdutosVenda();
    }

    Public Function DadosPagamentosVenda(){
        $dao = new RelatoriosVendasDao();
        $dadosPagamento = $dao->DadosPagamentosVenda();
        $i=0;
        $total = count($dadosPagamento[1]);
        while ($i<$total){
            $dadosPagamento[1][$i]['DTA_PAGAMENTO'] = $this->ConverteDataBanco($dadosPagamento[1][$i]['DTA_PAGAMENTO']);
            $i++;
        }
        return $dadosPagamento;
    }

    Public Function VendasFechadas(){
        $dao = new RelatoriosVendasDao();
        $vendas = $dao->VendasFechadas($_SESSION['cod_cliente_final']);
        $totalPagamentos = '';
        for ($i=0;$i<count($vendas[1]);$i++){
            $vendas[1][$i]['DTA_VENDA'] = $this->ConverteDataBanco($vendas[1][$i]['DTA_VENDA']);
            $result[$i]['VENDAS']=$vendas[1][$i];
            $dadosPagamentos = $dao->DadosPagamentosResumidoVenda($vendas[1][$i]['COD_VENDA']);
            $totalPagamentos = $this->ContabilizaPagamentos($totalPagamentos, $dadosPagamentos);
            $dadosPagamentos = BaseModel::FormataMoedaInArray($dadosPagamentos, 'VLR_PAGAMENTO|VLR_PAGAMENTO_LIQUIDO|VLR_PORCENTAGEM');
            $dadosPagamentos = BaseModel::AtualizaDataInArray($dadosPagamentos, 'DTA_PAGAMENTO');
            $result[$i]['PAGAMENTOS']=$dadosPagamentos[1];
            
        }
        for ($i=0;$i<count($totalPagamentos);$i++){
            $totalPagamentos[$i]['VLR_PAGAMENTO_BRUTO'] = number_format($totalPagamentos[$i]['VLR_PAGAMENTO_BRUTO'],2,',','.');
            $totalPagamentos[$i]['VLR_PORCENTAGEM'] = number_format($totalPagamentos[$i]['VLR_PORCENTAGEM'],2,',','.');
            $totalPagamentos[$i]['VLR_PAGAMENTO_LIQUIDO'] = number_format($totalPagamentos[$i]['VLR_PAGAMENTO_LIQUIDO'],2,',','.');
        }
        $result[count($result)]['TOTAL_PAGAMENTOS']=$totalPagamentos;
        return json_encode($result);
    }

    Public Function ContabilizaPagamentos($totalPagamentos, $dadosPagamentos){
        for($i=0;$i<count($dadosPagamentos[1]);$i++){
            if (!empty($totalPagamentos)){
                $result=$this->VerificaTipoPagamento($dadosPagamentos[1][$i]['DSC_TIPO_PAGAMENTO'], $totalPagamentos);
            }else{
                $result[0]=false;
                $result[1]=0;
            }
            $indice = $result[1];
            $totalPagamentos[$indice]['DSC_TIPO_PAGAMENTO']=$dadosPagamentos[1][$i]['DSC_TIPO_PAGAMENTO'];
            $totalPagamentos[$indice]['VLR_PORCENTAGEM']=$dadosPagamentos[1][$i]['VLR_PORCENTAGEM'];
            if (!$result[0]){
                $totalPagamentos[$indice]['VLR_PAGAMENTO_BRUTO']=$dadosPagamentos[1][$i]['VLR_PAGAMENTO'];
                $totalPagamentos[$indice]['VLR_PAGAMENTO_LIQUIDO']=$dadosPagamentos[1][$i]['VLR_PAGAMENTO_LIQUIDO'];  
            }else{
                $totalPagamentos[$indice]['VLR_PAGAMENTO_BRUTO']+=$dadosPagamentos[1][$i]['VLR_PAGAMENTO'];
                $totalPagamentos[$indice]['VLR_PAGAMENTO_LIQUIDO']+=$dadosPagamentos[1][$i]['VLR_PAGAMENTO_LIQUIDO'];            
            }
        }
        return $totalPagamentos;
    }
    
    Public Function VerificaTipoPagamento($tipoPagamento, $totalPagamentos){
        $result[0]=false;
        $result[1]=count($totalPagamentos);
        for($i=0;$i<count($totalPagamentos);$i++){
            if ($tipoPagamento===$totalPagamentos[$i]['DSC_TIPO_PAGAMENTO']){
                $result[0]=true;
                $result[1]=$i;
                return $result;
            }
        }
        return $result;
    }
    
    Public Function PagamentosRecebidos(){
        $dao = new RelatoriosVendasDao();
        $lista = $dao->PagamentosRecebidos($_SESSION['cod_cliente_final']);
        $vlrTotal=0;
        for ($i=0;$i<count($lista[1]);$i++){
            $vlrTotal += $lista[1][$i]['VLR_PAGAMENTO'];
        }
        $lista[1][count($lista[1])]['VLR_TOTAL'] = number_format($vlrTotal,2,",",".");
        $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO');
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
        return json_encode($lista);
    }

    Public Function PagamentosRecebidosAtual(){
        $dao = new RelatoriosVendasDao();
        $lista = $dao->PagamentosRecebidosAtual($_SESSION['cod_cliente_final']);
        $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO');
        $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
        return json_encode($lista);
    }

    Public Function VendasAbertas(){
        $dao = new RelatoriosVendasDao();
        $lista = $dao->VendasAbertas($_SESSION['cod_cliente_final']);
        $lista = $lista[1];
        $total = count($lista);
        $i=0;
        $data = array();
        while($i<$total ) {
            $data[] = array(
                'codVenda' => $lista[$i]['COD_VENDA'],
                'dscCliente' => $lista[$i]['DSC_CLIENTE'],
                'dtaVenda' => $this->ConverteDataBanco($lista[$i]['DTA_VENDA']),
                'vlrTotal' => number_format($lista[$i]['VLR_VENDA'],2),
                'dscVeiculo' => $lista[$i]['DSC_VEICULO'],
                'nmeVendedor' => $lista[$i]['NME_USUARIO_COMPLETO']
            );
            $i++;
        }

        return json_encode($data);
    }

    Public Function VendasJustificadas(){
        $dao = new RelatoriosVendasDao();
        $lista = $dao->VendasJustificadas($_SESSION['cod_cliente_final']);
        $total = count($lista);
        $i=0;
        $data = array();
        while($i<$total ) {
            $data[] = array(
                'codVenda' => $lista[$i]['COD_VENDA'],
                'dscCliente' => $lista[$i]['DSC_CLIENTE'],
                'dtaVenda' => $this->ConverteDataBanco($lista[$i]['DTA_VENDA']),
                'vlrTotal' => number_format($lista[$i]['VLR_VENDA'],2),
                'dscVeiculo' => $lista[$i]['DSC_VEICULO'],
                'nmeVendedor' => $lista[$i]['NME_USUARIO_COMPLETO'],
                'txtJustificativa' => $lista[$i]['TXT_JUSTIFICATIVA']
            );
            $i++;
        }

        return json_encode($data);
    }
}
?>
