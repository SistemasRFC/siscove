<?php
include_once("../../Dao/BaseDao.php");
class RelatoriosEstoqueDao extends BaseDao
{
    function RelatoriosVendasDao(){
        $this->conect();
    }

    function ListarHistoricoEstoque($codClienteFinal){
        $sql_lista = "SELECT COD_MOVIMENTACAO,
                             DTA_MOVIMENTACAO,
                             TPO_MOVIMENTACAO,
                             COD_PRODUTO,
                             DSC_PRODUTO,
                             DSC_MARCA,
                             CASE WHEN IND_TIPO_PRODUTO = 'S' THEN 'Semi-Novo' 
                                  WHEN IND_TIPO_PRODUTO = 'N' THEN 'Novo'
                             ELSE '' END AS IND_TIPO_PRODUTO,
                             QTD_MOVIMENTACAO
              FROM
            (SELECT VP.COD_VENDA AS COD_MOVIMENTACAO,
                    VP.DTA_VENDA_PRODUTO AS DTA_MOVIMENTACAO,
                     'Saída' AS TPO_MOVIMENTACAO,
                     P.COD_PRODUTO,
                     P.DSC_PRODUTO,
                     P.IND_TIPO_PRODUTO,
                     M.DSC_MARCA,
                     VP.QTD_VENDIDA AS QTD_MOVIMENTACAO
              FROM RE_VENDA_PRODUTO VP
             INNER JOIN EN_PRODUTO P
                ON VP.COD_PRODUTO = P.COD_PRODUTO
              LEFT JOIN EN_MARCA M
                ON P.COD_MARCA = M.COD_MARCA
             WHERE P.TPO_PRODUTO = 'P'
               AND VP.IND_ESTOQUE = 'S'
               AND P.COD_CLIENTE_FINAL = $codClienteFinal
            UNION
            SELECT EE.NRO_SEQUENCIAL AS COD_MOVIMENTACAO,
                    EE.DTA_ENTRADA_PRODUTO AS DTA_MOVIMENTACAO,
                             'Entrada' AS TPO_MOVIMENTACAO,
                             P.COD_PRODUTO,
                             P.DSC_PRODUTO,
                             P.IND_TIPO_PRODUTO,
                             M.DSC_MARCA,
                             EE.QTD_ENTRADA AS QTD_MOVIMENTACAO
              FROM EN_ENTRADA_ESTOQUE EE
             INNER JOIN EN_PRODUTO P
                ON EE.COD_PRODUTO = P.COD_PRODUTO
              LEFT JOIN EN_MARCA M
                ON P.COD_MARCA = M.COD_MARCA
             WHERE P.TPO_PRODUTO = 'P'
               AND P.COD_CLIENTE_FINAL = $codClienteFinal
            UNION
            SELECT BE.NRO_SEQUENCIAL AS COD_MOVIMENTACAO,
                    BE.DTA_BAIXA AS DTA_MOVIMENTACAO,
                             'Baixa no Estoque' AS TPO_MOVIMENTACAO,
                             P.COD_PRODUTO,
                             P.DSC_PRODUTO,
                             P.IND_TIPO_PRODUTO,
                             M.DSC_MARCA,
                             BE.QTD_BAIXA AS QTD_MOVIMENTACAO
              FROM EN_BAIXA_ESTOQUE BE
             INNER JOIN EN_PRODUTO P
                ON BE.COD_PRODUTO = P.COD_PRODUTO
              LEFT JOIN EN_MARCA M
                ON P.COD_MARCA = M.COD_MARCA
             WHERE P.TPO_PRODUTO = 'P'
               AND P.COD_CLIENTE_FINAL = $codClienteFinal
            UNION
            SELECT VRD.NRO_SEQUENCIAL AS COD_MOVIMENTACAO,
                   VRD.DTA_EMISSAO_NOTA AS DTA_MOVIMENTACAO,
                   'Devolução' AS TPO_MOVIMENTACAO,
                   P.COD_PRODUTO,
                   P.DSC_PRODUTO,
                   P.IND_TIPO_PRODUTO,
                   M.DSC_MARCA,
                   EE.QTD_ENTRADA AS QTD_MOVIMENTACAO
              FROM EN_VENDA_REFERENCIA_DEVOLUCAO VRD
             INNER JOIN EN_ENTRADA_ESTOQUE EE
                ON VRD.COD_VENDA = EE.NRO_SEQUENCIAL
             INNER JOIN EN_PRODUTO P
                ON EE.COD_PRODUTO = P.COD_PRODUTO
              LEFT JOIN EN_MARCA M
                ON P.COD_MARCA = M.COD_MARCA
             WHERE P.TPO_PRODUTO = 'P'
               AND P.COD_CLIENTE_FINAL = $codClienteFinal ) AS X
             WHERE 1=1";
             if (filter_input(INPUT_POST, 'dtaMovimentacaoInicio', FILTER_SANITIZE_STRING) != ''){
                $sql_lista.=" AND DATE(X.DTA_MOVIMENTACAO) >= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaMovimentacaoInicio', FILTER_SANITIZE_STRING))."'";
             }
             
             if (filter_input(INPUT_POST, 'dtaMovimentacaoFim', FILTER_SANITIZE_STRING) != ''){
                $sql_lista.=" AND DATE(X.DTA_MOVIMENTACAO) <= '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaMovimentacaoFim', FILTER_SANITIZE_STRING))."'";
             }
             
             if (filter_input(INPUT_POST, 'dscProduto', FILTER_SANITIZE_STRING) != ''){
                $sql_lista.=" AND X.DSC_PRODUTO LIKE '%".filter_input(INPUT_POST, 'dscProduto', FILTER_SANITIZE_STRING)."%'";
             } 
             
//             if (filter_input(INPUT_POST, 'indCondicaoNovo', FILTER_SANITIZE_STRING) == 'false' && filter_input(INPUT_POST, 'indCondicaoSeminovo', FILTER_SANITIZE_STRING) == 'false'){
//                 $sql_lista.=" AND COALESCE(IND_TIPO_PRODUTO, '') = ''";
//             }else 
             if (filter_input(INPUT_POST, 'indCondicaoNovo', FILTER_SANITIZE_STRING) == 'true' && filter_input(INPUT_POST, 'indCondicaoSeminovo', FILTER_SANITIZE_STRING) == 'true'){
                 $sql_lista.=" AND IND_TIPO_PRODUTO IN('N','S')";
             }else{
                if (filter_input(INPUT_POST, 'indCondicaoNovo', FILTER_SANITIZE_STRING) == 'true'){
                   $sql_lista.=" AND IND_TIPO_PRODUTO LIKE 'N'";
                } 

                if (filter_input(INPUT_POST, 'indCondicaoSeminovo', FILTER_SANITIZE_STRING) == 'true'){
                   $sql_lista.=" AND IND_TIPO_PRODUTO LIKE 'S'";
                }
             }
             $sql_lista.=" ORDER BY DTA_MOVIMENTACAO";
//             echo $sql_lista; die;
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function ListarProdutosMaisVendidos($codClienteFinal){
        $dtaInicio = filter_input(INPUT_POST, 'dtaVendaInicio', FILTER_SANITIZE_STRING);
        $dtaFim = filter_input(INPUT_POST, 'dtaVendaFim', FILTER_SANITIZE_STRING);
        $sql_lista = "
            SELECT P.DSC_PRODUTO,
                   M.DSC_MARCA,
                   SUM(VP.QTD_VENDIDA) AS QTD_VENDA
              FROM RE_VENDA_PRODUTO VP
             INNER JOIN EN_PRODUTO P
                ON VP.COD_PRODUTO = P.COD_PRODUTO
             INNER JOIN EN_MARCA M
                ON P.COD_MARCA = M.COD_MARCA
             INNER JOIN EN_VENDA V
                ON VP.COD_VENDA = V.COD_VENDA
             WHERE NRO_STATUS_VENDA = 'F'             
               AND P.COD_CLIENTE_FINAL = $codClienteFinal
               AND VP.DTA_VENDA_PRODUTO >= '".$this->ConverteDataForm($dtaInicio)." 00:00:00'
               AND VP.DTA_VENDA_PRODUTO <= '".$this->ConverteDataForm($dtaFim)." 23:59:59'
               AND P.TPO_PRODUTO = 'P'
             GROUP BY P.DSC_PRODUTO, M.DSC_MARCA
             ORDER BY SUM(VP.QTD_VENDIDA) DESC, P.DSC_PRODUTO";
        //echo $sql_lista; die;
        $lista = $this->selectDB("$sql_lista", false);
        return $lista;
    }

    function ListarEstoque($codClienteFinal, $parametro=null){
        $sql = " SELECT P.COD_PRODUTO,
                    P.DSC_PRODUTO,
                    M.DSC_MARCA,
                    CASE WHEN IND_TIPO_PRODUTO = 'S' THEN 'Semi-Novo' 
                         WHEN IND_TIPO_PRODUTO = 'N' THEN 'Novo'
                    ELSE '' END AS IND_TIPO_PRODUTO,
                    P.NRO_ARO_PNEU,
                    SUM(COALESCE(E.QTD_ESTOQUE,0)) AS QTD_ESTOQUE,
                    DSC_FORNECEDOR
               FROM EN_PRODUTO P
               LEFT JOIN EN_MARCA M
                 ON P.COD_MARCA = M.COD_MARCA
               LEFT JOIN EN_ENTRADA_ESTOQUE EE
                 ON P.COD_PRODUTO = EE.COD_PRODUTO
               LEFT JOIN EN_ESTOQUE E
                 ON EE.COD_PRODUTO = E.COD_PRODUTO
                AND EE.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
                AND E.QTD_ESTOQUE>0
               LEFT JOIN EN_ENTRADA ET
                 ON EE.NRO_SEQUENCIAL = ET.NRO_SEQUENCIAL
               LEFT JOIN EN_FORNECEDOR F
                 ON ET.COD_FORNECEDOR = F.COD_FORNECEDOR
              WHERE P.COD_CLIENTE_FINAL = $codClienteFinal
                AND P.TPO_PRODUTO = 'P'
                AND E.QTD_ESTOQUE>0";
        if ($parametro!=null){
            $sql.="  AND P.DSC_PRODUTO LIKE '%".$parametro."%'";
        }
        
        if (filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING)!="-1" && filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING)!=""){
            $sql.="  AND P.COD_TIPO_PRODUTO = ".filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING);
        }
        
        if (filter_input(INPUT_POST, 'CondicaoNovo', FILTER_SANITIZE_STRING) == 'false' && filter_input(INPUT_POST, 'CondicaoSeminovo', FILTER_SANITIZE_STRING) == 'false'){
                 $sql.=" AND COALESCE(IND_TIPO_PRODUTO, '') = ''";
        }else if (filter_input(INPUT_POST, 'CondicaoNovo', FILTER_SANITIZE_STRING) == 'true' && filter_input(INPUT_POST, 'CondicaoSeminovo', FILTER_SANITIZE_STRING) == 'true'){
                 $sql.=" AND IND_TIPO_PRODUTO IN('N','S')";
            }else{
                if (filter_input(INPUT_POST, 'CondicaoNovo', FILTER_SANITIZE_STRING) == 'true'){
                   $sql.=" AND IND_TIPO_PRODUTO LIKE 'N'";
                } 

                if (filter_input(INPUT_POST, 'CondicaoSeminovo', FILTER_SANITIZE_STRING) == 'true'){
                   $sql.=" AND IND_TIPO_PRODUTO LIKE 'S'";
                }
            }
        $sql.=" GROUP BY P.COD_PRODUTO, 
                       P.NRO_ARO_PNEU,
                       P.DSC_PRODUTO,
                       M.DSC_MARCA
              ORDER BY P.NRO_ARO_PNEU, P.DSC_PRODUTO";        
         return $this->selectDB("$sql", false);
    }

    function ListarEntradasEstoque($codClienteFinal, $parametro=null){
        $sql = " SELECT P.COD_PRODUTO,
                    ET.NRO_SEQUENCIAL,
                    ET.DTA_ENTRADA,
                    EE.VLR_UNITARIO,
                    EE.VLR_MINIMO,
                    EE.VLR_VENDA,
                    P.NRO_ARO_PNEU,
                    CASE WHEN IND_TIPO_PRODUTO = 'S' THEN 'Semi-Novo' 
                         WHEN IND_TIPO_PRODUTO = 'N' THEN 'Novo'
                    ELSE '' END AS IND_TIPO_PRODUTO,
                    E.QTD_ESTOQUE
               FROM EN_PRODUTO P
               LEFT JOIN EN_MARCA M
                 ON P.COD_MARCA = M.COD_MARCA
               LEFT JOIN EN_ENTRADA_ESTOQUE EE
                 ON P.COD_PRODUTO = EE.COD_PRODUTO
               LEFT JOIN EN_ESTOQUE E
                 ON EE.COD_PRODUTO = E.COD_PRODUTO
                AND EE.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
                AND E.QTD_ESTOQUE>0
               LEFT JOIN EN_ENTRADA ET
                 ON EE.NRO_SEQUENCIAL = ET.NRO_SEQUENCIAL
              WHERE P.COD_CLIENTE_FINAL = $codClienteFinal
                AND P.TPO_PRODUTO = 'P'
                AND E.QTD_ESTOQUE>0";
        if ($parametro!=null){
            $sql.="  AND P.DSC_PRODUTO LIKE '%".$parametro."%'";
        }
        
        if (filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING)!="-1" && filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING)!=""){
            $sql.="  AND P.COD_TIPO_PRODUTO = ".filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING);
        }
        
        if (filter_input(INPUT_POST, 'CondicaoNovo', FILTER_SANITIZE_STRING) == 'false' && filter_input(INPUT_POST, 'CondicaoSeminovo', FILTER_SANITIZE_STRING) == 'false'){
                 $sql.=" AND COALESCE(IND_TIPO_PRODUTO, '') = ''";
        }else if (filter_input(INPUT_POST, 'CondicaoNovo', FILTER_SANITIZE_STRING) == 'true' && filter_input(INPUT_POST, 'CondicaoSeminovo', FILTER_SANITIZE_STRING) == 'true'){
                 $sql.=" AND IND_TIPO_PRODUTO IN('N','S')";
            }else{
                if (filter_input(INPUT_POST, 'CondicaoNovo', FILTER_SANITIZE_STRING) == 'true'){
                   $sql.=" AND IND_TIPO_PRODUTO LIKE 'N'";
                } 

                if (filter_input(INPUT_POST, 'CondicaoSeminovo', FILTER_SANITIZE_STRING) == 'true'){
                   $sql.=" AND IND_TIPO_PRODUTO LIKE 'S'";
                }
            }
        $sql.=" ORDER BY P.NRO_ARO_PNEU, ET.DTA_ENTRADA";        
         return $this->selectDB("$sql", false);
    }

    Public Function ListarEstoqueProduto($codClienteFinal){
        $sql = "SELECT E.COD_PRODUTO,
                       P.DSC_PRODUTO,
                       SUM(E.QTD_ESTOQUE) AS QTD_ESTOQUE,
                       P.VLR_MINIMO,
                       P.VLR_PRODUTO,
                       P.NRO_ARO_PNEU,
                       M.DSC_MARCA
                  FROM EN_ESTOQUE E
                 INNER JOIN EN_PRODUTO P
                    ON E.COD_PRODUTO = P.COD_PRODUTO
                 INNER JOIN EN_MARCA M
                    ON P.COD_MARCA = M.COD_MARCA
                 WHERE P.COD_CLIENTE_FINAL = $codClienteFinal";
        if (filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING)!="-1" && filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING)!=""){
            $sql.="  AND P.COD_TIPO_PRODUTO = ".filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_STRING);
        }
        $sql.="  GROUP BY E.COD_PRODUTO, P.DSC_PRODUTO, P.VLR_MINIMO, P.VLR_PRODUTO
                HAVING SUM(E.QTD_ESTOQUE)>0
                 ORDER BY P.NRO_ARO_PNEU, P.DSC_PRODUTO";
//        echo strtoupper($sql);
         return $this->selectDB($sql, false);
    }
}
?>
