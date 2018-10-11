<?php
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/LucroVendasDao.php");
class LucroVendasModel extends BaseModel
{
    function LucroVendasModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Function DadosComissao(){
        $dao = new LucroVendasDao();
        $lista = $dao->DadosComissao($_SESSION['cod_cliente_final']);
        if ($lista[0]){
    //        $lista = $lista[1];
            $data = array();
            $codVendaAtual=0;        
            $vlrLucroTotal=0;
            $vlrLucroVenda=0;
            $vlrTotal=0;
            $vlrTotalVenda=0;
            $primeira=true;
            for($i=0;$i<count($lista[1]);$i++){
                $vlrLucroTotal=$vlrLucroTotal+($lista[1][$i]['VLR_LUCRO_UNITARIO']);
                $vlrTotal = $vlrTotal+(($lista[1][$i]['VLR_VENDA']-$lista[1][$i]['VLR_DESCONTO'])*$lista[1][$i]['QTD_VENDIDA']);
            }    
            $lista[1][count($lista[1])]['VLR_LUCRO_TOTAL']=$vlrLucroTotal;
            $lista[1][count($lista[1])-1]['VLR_TOTAL']=$vlrTotal;
            $lista[1][count($lista[1])-1]['VLR_PORCENTAGEM_LUCRO_TOTAL']=($vlrLucroTotal*100)/$vlrTotal;
            $lista = BaseModel::FormataMoedaInArray($lista, 'VLR_CUSTO|VLR_PORCENTAGEM_LUCRO_VENDA|VLR_PORCENTAGEM_LUCRO_TOTAL|VLR_VENDA|VLR_VENDA_PRODUTO|VLR_COM_DESCONTO|VLR_COMISSAO_VENDEDOR|VLR_COMISSAO_FUNCIONARIO|VLR_DESCONTO|VLR_TOTAL|VLR_LUCRO_TOTAL|VLR_TOTAL_VENDA|VLR_LUCRO_VENDA|VLR_UNITARIO|VLR_IMPOSTO|VLR_LUCRO_UNITARIO|VLR_PORCENTAGEM_PAGAMENTO|VLR_IMPOSTO_CALCULADO');
            $lista = BaseModel::AtualizaDataInArray($lista, 'DTA_VENDA');
            $lista = $lista[1];       
        }        
        return json_encode($lista);
    }

}
?>
