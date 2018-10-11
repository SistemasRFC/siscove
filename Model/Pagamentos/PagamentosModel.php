<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Pagamentos/PagamentosDao.php");
class PagamentosModel extends BaseModel
{
    function PagamentosModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    function ListarContas(){
        $dao = new PagamentosDao();
        $lista = $dao->ListarContas($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENCIMENTO');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_CONTA');
            $lista = BaseModel::AtualizaBooleanInArray($lista, 'IND_CONTA_PAGA', 'PAGO');
        }
        return json_encode($lista);
    }

    function ListarPagamentos(){
        $dao = new PagamentosDao();
        $codConta = filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT);
        $lista = $dao->ListarPagamentos($codConta);
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');            
        }
        return json_encode($lista);
    }

    function ListarChequesRecebidos(){
        $dao = new PagamentosDao();
        $lista = $dao->ListarChequesRecebidos($_SESSION['cod_cliente_final']);
        if ($lista[0]){
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_PAGAMENTO');
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_PAGAMENTO');
        }
        return json_encode($lista);
    }

    function InserirPagamento($Json=true){
        $dao = new PagamentosDao();
        $codTipoPagamento = filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT);
        $qtdParcelas = filter_input(INPUT_POST, 'qtdParcelas', FILTER_SANITIZE_NUMBER_INT);
        $nroParcelaAtual = filter_input(INPUT_POST, 'nroParcelaAtual', FILTER_SANITIZE_NUMBER_INT);
        $dtaPagamento = filter_input(INPUT_POST, 'dtaPagamento', FILTER_SANITIZE_STRING);
        $dao->IniciaTransacao();  
        $return[0] = true;    
        for($i=$nroParcelaAtual-1;$i<$qtdParcelas;$i++){
            if ($return[0]){
                $return =$dao->InserirPagamento($dtaPagamento, $_SESSION['cod_cliente_final'], $qtdParcelas, $i+1);
            }
            $data = $this->makeDate($dtaPagamento, 0, 1);
            $dtaPagamento = $data;
        }        
        if ($return[0]){
            $dao->ComitaTransacao();
        }else{
            $dao->RolbackTransacao();
        }
        if ($Json){
            return json_encode($return);
        }else{
            return $retorno;
        }
    }

    function UpdatePagamento($Json=true){
        $dao = new PagamentosDao();
        $lista = $dao->UpdatePagamento();
        if ($Json){
            return json_encode($lista);
        }else{
            return $lista;
        }
    }

    function InserirConta($Json=true){
        $dao = new PagamentosDao();
        $codTipoPagamento = filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_NUMBER_INT);
        $dtaPagamento = filter_input(INPUT_POST, 'dtaVencimento', FILTER_SANITIZE_STRING);
        $codTipoConta = filter_input(INPUT_POST, 'codTipoConta', FILTER_SANITIZE_STRING);
        $dao->IniciaTransacao();
        if ($codTipoConta == 1){
            $return = $dao->InserirContaFixa();
            if($return[0]){
                $codContaFixa = $return[2];
                $return = $dao->InserirConta($dtaPagamento, $_SESSION['cod_cliente_final'], $codContaFixa);
            }
        }else{
            $codContaFixa="NULL";
            $return =$dao->InserirConta($dtaPagamento, $_SESSION['cod_cliente_final'], $codContaFixa);
        }
        if ($return[0]){
            $dao->ComitaTransacao();
        }else{
            $dao->RolbackTransacao();
        }
        if ($Json){
            return json_encode($return);
        }else{
            return $retorno;
        }
    }

    function UpdateConta($Json=true){
        $dao = new PagamentosDao();
        $codTipoConta = filter_input(INPUT_POST, 'codTipoConta', FILTER_SANITIZE_STRING);
        $codConta = $dao->Populate('codConta', 'I');
        $codContaFixa = $dao->Populate('codContaFixa', 'I');
        if($codTipoConta == 1){
            if ($codContaFixa==0){
                $result = $dao->InserirContaFixa();
                if($result[0]){
                    $codContaFixa = $result[2];
                    if ($codConta>0){
                        $result = $dao->UpdateConta($codContaFixa);
                    }else{
                        $result = $dao->InserirConta($dao->Populate('dtaVencimento', 'D'), $_SESSION['cod_cliente_final'], $codContaFixa);
                    }
                }
            }else{
                if ($codConta==0){
                    $result = $dao->InserirConta($dao->Populate('dtaVencimento', 'D'), $_SESSION['cod_cliente_final'], $codContaFixa);
                }else{
                    $result = $dao->UpdateConta($codContaFixa);
                }
            }
        }else{
            $result = $dao->UpdateConta($codContaFixa);
        }
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }
    }

    function DeletarConta($Json=true){
        $dao = new PagamentosDao();
        $codConta = filter_input(INPUT_POST, 'codConta', FILTER_SANITIZE_NUMBER_INT);
        $codContaFixa = $dao->Populate('codContaFixa', 'I');
        $codTipoConta = filter_input(INPUT_POST, 'codTipoConta', FILTER_SANITIZE_STRING);
        $dao->IniciaTransacao();
        if($codTipoConta == 1){
            if ($codContaFixa>0){
                $result = $dao->UpdateContaFixa($codContaFixa);
                if ($result[0]){
                    $result = $dao->ListarPagamentos($codConta);                
                    if ($result[0]){
                        if ($result[1]!=null){
                            $result = $this->DeletarPagamentos($dao, $codConta);
                        }
                        if ($result[0]){
                            $result = $dao->UpdateContaFixa($codContaFixa);         
                        }                        
                    }     
                }
            }else{
                $result = $this->DeletarPagamentos($dao, $codConta);                
            }
        }else{
            $result = $this->DeletarPagamentos($dao, $codConta);
        }
        if ($result[0]){
            $result = $dao->DeletarConta();
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

    Public Function DeletarPagamentos($dao, $codConta){
        $result = $dao->ListarPagamentos($codConta);
        if ($result[0]){
            if ($result[1]!=null){
                $codPagamentos = '';
                for ($i=0;$i<count($result[1]);$i++){
                    $codPagamentos .= $result[1][$i]['COD_PAGAMENTO'].', ';
                }
                $codPagamentos = substr($codPagamentos, 0, strlen($codPagamentos)-2);
                if (trim($codPagamentos)!=''){
                    $result = $dao->DeletarPagamento($codPagamentos);
                }else{
                    $result[0] = true;
                }
            }
        }
        return $result;
    }
    function DeletarPagamento($Json=true){
        $dao = new PagamentosDao();
        $codPagamentos = filter_input(INPUT_POST, 'codPagamento', FILTER_SANITIZE_STRING);
        $result = $dao->DeletarPagamento($codPagamentos);
        if ($Json){
            return json_encode($result);
        }else{
            return $result;
        }
    }
    
    function makeDate($date, $days=0, $mounths=0, $years=0){
        $date = explode("/", $date);
        return date('d/m/Y', mktime(0, 0, 0, $date[1] + $mounths, $date[0] +  $days, $date[2] + $years) );
    }
}
?>
