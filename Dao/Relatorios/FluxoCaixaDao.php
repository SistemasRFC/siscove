<?php
include_once("../../Dao/BaseDao.php");
include_once("../../Form/Relatorios/FluxoCaixaForm.php");
class FluxoCaixaDao extends BaseDao
{
    function FluxoCaixaDao(){
        $this->conect();
    }
    /**
     * Retorna uma lista das movimentações do fluxo do caixa.
     * Usado no FluxoCaixaModel
     * @param <type> $codClienteFinal
     * @return Array()
     */
    function BuscaMovimentacoes($codClienteFinal){
        $form = new FluxoCaixaForm(); 
        $sql_lista = "SELECT MO.DTA_MOVIMENTACAO,
                             (SELECT SUM(VLR_MOVIMENTACAO) AS VALOR
                                FROM EN_MOVIMENTACOES
                                    WHERE TPO_MOVIMENTACAO = 'D'
                                      AND TPO_CLASSIFICACAO_DESPESA = 'F'
                                      AND DTA_MOVIMENTACAO = MO.DTA_MOVIMENTACAO
                                    GROUP BY MO.DTA_MOVIMENTACAO) AS  VLR_FIXA,
                             (SELECT SUM(VLR_MOVIMENTACAO) AS VALOR
                                FROM EN_MOVIMENTACOES
                                    WHERE TPO_MOVIMENTACAO = 'D'
                                      AND TPO_CLASSIFICACAO_DESPESA = 'NF'
                                      AND DTA_MOVIMENTACAO = MO.DTA_MOVIMENTACAO
                                    GROUP BY MO.DTA_MOVIMENTACAO) AS  VLR_ROTATIVA,
                             (SELECT SUM(VLR_MOVIMENTACAO) AS VALOR
                                FROM EN_MOVIMENTACOES
                                    WHERE TPO_MOVIMENTACAO = 'R'
                                      AND DTA_MOVIMENTACAO = MO.DTA_MOVIMENTACAO
                                    GROUP BY MO.DTA_MOVIMENTACAO) AS  VLR_RECEITA
                        FROM EN_MOVIMENTACOES MO
                       WHERE MO.DTA_MOVIMENTACAO >= '".$this->ConverteDataForm($form->getDtaVendaInicio())."'
                         AND MO.DTA_MOVIMENTACAO <= '".$this->ConverteDataForm($form->getDtaVendaFim())."'
                         AND MO.COD_CLIENTE_FINAL = $codClienteFinal
                       GROUP BY MO.DTA_MOVIMENTACAO";
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function BuscaDespesasFixas($codClienteFinal){
        $form = new FluxoCaixaForm();
        $sql_lista = "SELECT COD_MOVIMENTACAO,
                             DSC_MOVIMENTACAO,
                             TPO_MOVIMENTACAO,
                             DTA_MOVIMENTACAO,
                             VLR_MOVIMENTACAO
                        FROM EN_MOVIMENTACOES
                       WHERE DTA_MOVIMENTACAO >= '".$this->ConverteDataForm($form->getDtaVendaInicio())."'
                         AND DTA_MOVIMENTACAO <= '".$this->ConverteDataForm($form->getDtaVendaFim())."'
                         AND COD_CLIENTE_FINAL = $codClienteFinal
                         AND TPO_MOVIMENTACAO = 'D'
                         AND TPO_CLASSIFICACAO_DESPESA = 'F'
                       ORDER BY TPO_MOVIMENTACAO, DTA_MOVIMENTACAO";
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function BuscaDespesasRotativas($codClienteFinal){
        $form = new FluxoCaixaForm();
        $sql_lista = "SELECT COD_MOVIMENTACAO,
                             DSC_MOVIMENTACAO,
                             TPO_MOVIMENTACAO,
                             DTA_MOVIMENTACAO,
                             VLR_MOVIMENTACAO
                        FROM EN_MOVIMENTACOES
                       WHERE DTA_MOVIMENTACAO >= '".$this->ConverteDataForm($form->getDtaVendaInicio())."'
                         AND DTA_MOVIMENTACAO <= '".$this->ConverteDataForm($form->getDtaVendaFim())."'
                         AND COD_CLIENTE_FINAL = $codClienteFinal
                         AND TPO_MOVIMENTACAO = 'D'
                         AND TPO_CLASSIFICACAO_DESPESA = 'NF'
                       ORDER BY TPO_MOVIMENTACAO, DTA_MOVIMENTACAO";
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function BuscaReceitas($codClienteFinal){
        $form = new FluxoCaixaForm();
        $sql_lista = "SELECT COD_MOVIMENTACAO,
                             TPO_MOVIMENTACAO,
                             DTA_MOVIMENTACAO,
                             CASE WHEN TPO_CLASSIFICACAO_RECEITA = 'D' THEN 'Dinheiro'
                                  WHEN TPO_CLASSIFICACAO_RECEITA = 'CD' THEN 'Cartão de Débito'
                                  WHEN TPO_CLASSIFICACAO_RECEITA = 'CC' THEN 'Cartão de Crédito'
                                  WHEN TPO_CLASSIFICACAO_RECEITA = 'CH' THEN 'Cheque'
                                  WHEN TPO_CLASSIFICACAO_RECEITA = 'M' THEN 'Mercadoria'
                             ELSE ''
                             END AS TPO_CLASSIFICACAO,
                             TPO_CLASSIFICACAO_RECEITA,
                             VLR_MOVIMENTACAO,
                             VLR_ADIANTAMENTO,
                             IND_ADIANTAMENTO,
                             DTA_ADIANTAMENTO
                        FROM EN_MOVIMENTACOES
                       WHERE DTA_MOVIMENTACAO >= '".$this->ConverteDataForm($form->getDtaVendaInicio())."'
                         AND DTA_MOVIMENTACAO <= '".$this->ConverteDataForm($form->getDtaVendaFim())."'
                         AND COD_CLIENTE_FINAL = $codClienteFinal
                         AND TPO_MOVIMENTACAO = 'R'
                       ORDER BY TPO_MOVIMENTACAO, DTA_MOVIMENTACAO";
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }
}
?>
