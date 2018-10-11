<?
include_once("../../Model/BaseModel.php");
include_once("../../Dao/Relatorios/FluxoCaixaDao.php");
class FluxoCaixaModel extends BaseModel
{
    function FluxoCaixaModel(){
        If (!isset($_SESSION)){
            ob_start();
            session_start();
        }
    }

    Function BuscaFluxo(){
        $dao = new FluxoCaixaDao(); 
        $dadosFluxo = $dao->BuscaMovimentacoes($_SESSION['cod_cliente_final']);
        $dadosDespesasFixas = $dao->BuscaDespesasFixas($_SESSION['cod_cliente_final']);
        $dadosDespesasRotativas = $dao->BuscaDespesasRotativas($_SESSION['cod_cliente_final']);
        $dadosReceitas = $dao->BuscaReceitas($_SESSION['cod_cliente_final']);
        $vlrTotalFixa =0;
        $vlrTotalRotativa=0;
        $vlrTotalReceita=0;
        for($i=0;$i<count($dadosFluxo);$i++){
            $dadosFluxo[$i]['DTA_MOVIMENTACAO'] = $this->ConverteDataBanco($dadosFluxo[$i]['DTA_MOVIMENTACAO']);
            $vlrTotalFixa = $vlrTotalFixa + $dadosFluxo[$i]['VLR_FIXA'];
            $vlrTotalRotativa = $vlrTotalRotativa+$dadosFluxo[$i]['VLR_ROTATIVA'];
            $vlrTotalReceita = $vlrTotalReceita+$dadosFluxo[$i]['VLR_RECEITA'];
            $dadosFluxo[$i]['VLR_FIXA'] = number_format($dadosFluxo[$i]['VLR_FIXA'],2,',','.');
            $dadosFluxo[$i]['VLR_ROTATIVA'] = number_format($dadosFluxo[$i]['VLR_ROTATIVA'],2,',','.');
            $dadosFluxo[$i]['VLR_RECEITA'] = number_format($dadosFluxo[$i]['VLR_RECEITA'],2,',','.');
        }
        for($i=0;$i<count($dadosDespesasFixas);$i++){
            $dadosDespesasFixas[$i]['DTA_MOVIMENTACAO'] = $this->ConverteDataBanco($dadosDespesasFixas[$i]['DTA_MOVIMENTACAO']);
            $dadosDespesasFixas[$i]['VLR_MOVIMENTACAO'] = number_format($dadosDespesasFixas[$i]['VLR_MOVIMENTACAO'],2,',','.');
        }
        for($i=0;$i<count($dadosDespesasRotativas);$i++){
            $dadosDespesasRotativas[$i]['DTA_MOVIMENTACAO'] = $this->ConverteDataBanco($dadosDespesasRotativas[$i]['DTA_MOVIMENTACAO']);
            $dadosDespesasRotativas[$i]['VLR_MOVIMENTACAO'] = number_format($dadosDespesasRotativas[$i]['VLR_MOVIMENTACAO'],2,',','.');
        }
        for($i=0;$i<count($dadosReceitas);$i++){
            $dadosReceitas[$i]['DTA_MOVIMENTACAO'] = $this->ConverteDataBanco($dadosReceitas[$i]['DTA_MOVIMENTACAO']);
            $dadosReceitas[$i]['DTA_ADIANTAMENTO'] = $this->ConverteDataBanco($dadosReceitas[$i]['DTA_ADIANTAMENTO']);
            $dadosReceitas[$i]['VLR_MOVIMENTACAO'] = number_format($dadosReceitas[$i]['VLR_MOVIMENTACAO'],2,',','.');
        }
        $data = array();
        $data[] = array(
            'dadosFluxo' => $dadosFluxo,
            'dadosDespesasFixas' => $dadosDespesasFixas,
            'dadosDespesasRotativas' => $dadosDespesasRotativas,
            'dadosReceitas' => $dadosReceitas,
            'vlrTotalFixa' => number_format($vlrTotalFixa,2,',','.'),
            'vlrTotalRotativa' => number_format($vlrTotalRotativa,2,',','.'),
            'vlrTotalReceita' => number_format($vlrTotalReceita,2,',','.'));

        return json_encode($data);
    }

}
?>
