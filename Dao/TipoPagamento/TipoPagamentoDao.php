<?php
include_once("../../Dao/BaseDao.php");
class TipoPagamentoDao extends BaseDao
{
    Public Function TipoPagamentoDao(){
        $this->conect();
    }
    
    Public Function ListarTipoPagamento($codClienteFinal){
        $sql_lista = "SELECT COD_TIPO_PAGAMENTO,
                                 DSC_TIPO_PAGAMENTO,
                                 IND_ATIVO,
                                 VLR_PORCENTAGEM
                            FROM EN_TIPO_PAGAMENTO ORDER BY DSC_TIPO_PAGAMENTO";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarTipoPagamentoAtivo($codClienteFinal){
        $sql_lista = "SELECT COD_TIPO_PAGAMENTO,
                                 DSC_TIPO_PAGAMENTO,
                                 VLR_PORCENTAGEM
                            FROM EN_TIPO_PAGAMENTO
                           WHERE IND_ATIVO = 'S' ORDER BY DSC_TIPO_PAGAMENTO";
        return $this->selectDB("$sql_lista", false);
    }    

    Public Function AddTipoPagamento($codClienteFinal){
        $vlrPorcentagem = str_replace('.', '', filter_input(INPUT_POST, 'vlrPorcentagem', FILTER_SANITIZE_STRING));
        $vlrPorcentagem = str_replace(',', '.', $vlrPorcentagem);        
        $sql_lista = "
        INSERT INTO EN_TIPO_PAGAMENTO(COD_TIPO_PAGAMENTO, DSC_TIPO_PAGAMENTO, IND_ATIVO, VLR_PORCENTAGEM)
        VALUES(".$this->CatchUltimoCodigo('EN_TIPO_PAGAMENTO', 'COD_TIPO_PAGAMENTO').",
                                           '".filter_input(INPUT_POST, 'dscTipoPagamento', FILTER_SANITIZE_STRING)."',
                                           '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                                           '".$vlrPorcentagem."')";
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    Public Function UpdateTipoPagamento(){
        $vlrPorcentagem = str_replace('.', '', filter_input(INPUT_POST, 'vlrPorcentagem', FILTER_SANITIZE_STRING));
        $vlrPorcentagem = str_replace(',', '.', $vlrPorcentagem);          
        $sql_lista = 
         "UPDATE EN_TIPO_PAGAMENTO SET DSC_TIPO_PAGAMENTO='".filter_input(INPUT_POST, 'dscTipoPagamento', FILTER_SANITIZE_STRING)."',
                                     IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                                     VLR_PORCENTAGEM = '".$vlrPorcentagem."' 
           WHERE COD_TIPO_PAGAMENTO = ".filter_input(INPUT_POST, 'codTipoPagamento', FILTER_SANITIZE_STRING);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }
}
?>
