<?php
include_once("../../Dao/BaseDao.php");
class ProdutoDao extends BaseDao
{
    Public Function ProdutoDao(){
        $this->conect();
    }
    
    Public Function ListarProduto($codClienteFinal){
        $sql_lista = "
                 SELECT COD_PRODUTO,
                        DSC_PRODUTO,
                        DSC_MARCA,
                        P.COD_MARCA,
                        P.COD_TIPO_PRODUTO,
                        COALESCE(P.VLR_PRODUTO,0) AS VLR_VENDA,
                        COALESCE(P.VLR_MINIMO,0) AS VLR_MINIMO,
                        COALESCE(P.NRO_ARO_PNEU,0) AS NRO_ARO_PNEU,
                        IND_ATIVO,
                        IND_TIPO_PRODUTO,
                        P.COD_CFOP,
                        P.COD_NCM,
                        P.COD_ICMS_ORIGEM,
                        P.COD_ICMS_SITUACAO_TRIBUTARIA,
                        P.COD_PIS_SITUACAO_TRIBUTARIA,
                        P.COD_COFINS_SITUACAO_TRIBUTARIA,
                        P.COD_NCM,
                        N.COD_CATEGORIA_NCM
                   FROM EN_PRODUTO P
                  INNER JOIN EN_MARCA M
                     ON P.COD_MARCA = M.COD_MARCA
                   LEFT JOIN EN_NCM N
                     ON P.COD_NCM = N.COD_NCM
                  WHERE TPO_PRODUTO = 'P'
                    AND P.COD_CLIENTE_FINAL = $codClienteFinal
                  AND DSC_PRODUTO LIKE '".filter_input(INPUT_POST, 'parametro', FILTER_SANITIZE_STRING)."%'
                  ORDER BY DSC_PRODUTO,DSC_MARCA";
//        echo $sql_lista; die;
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarProdutosAtivos($codClienteFinal){
        $sql_lista = "SELECT COD_PRODUTO,
                             DSC_PRODUTO
                        FROM EN_PRODUTO
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal
                         AND IND_ATIVO ='S'
                       ORDER BY DSC_PRODUTO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function VerificaProduto($codClienteFinal){
        $sql = "SELECT COD_PRODUTO FROM EN_PRODUTO
                WHERE DSC_PRODUTO = '".filter_input(INPUT_POST, 'dscProduto', FILTER_SANITIZE_STRING)."'
                AND COD_MARCA = '".filter_input(INPUT_POST, 'codMarca', FILTER_SANITIZE_STRING)."'
                AND COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql", false);
    }
    
    Public Function AddProduto($codClienteFinal){
        $codProduto = $this->CatchUltimoCodigo('EN_PRODUTO', 'COD_PRODUTO');
        $vlrVenda = str_replace('.', '', filter_input(INPUT_POST, 'vlrVenda', FILTER_SANITIZE_STRING));
        $vlrVenda = str_replace(',', '.', $vlrVenda);
        $vlrMinimo = str_replace('.', '', filter_input(INPUT_POST, 'vlrMinimo', FILTER_SANITIZE_STRING));
        $vlrMinimo = str_replace(',', '.', $vlrMinimo);
        $sql_lista = "
                 INSERT INTO EN_PRODUTO (COD_PRODUTO,
                                         DSC_PRODUTO,
                                         VLR_PRODUTO,
                                         VLR_MINIMO,
                                         TPO_PRODUTO,
                                         COD_MARCA,
                                         IND_ALINHAMENTO,
                                         COD_CLIENTE_FINAL,
                                         COD_TIPO_PRODUTO,
                                         NRO_ARO_PNEU,
                                         IND_ATIVO,
                                         IND_TIPO_PRODUTO,                                         
                                         COD_CFOP,
                                         COD_NCM,
                                         COD_ICMS_ORIGEM,
                                         COD_ICMS_SITUACAO_TRIBUTARIA,
                                         COD_PIS_SITUACAO_TRIBUTARIA,
                                         COD_COFINS_SITUACAO_TRIBUTARIA)
                 VALUES(".$codProduto.",
                        '".filter_input(INPUT_POST, 'dscProduto', FILTER_SANITIZE_STRING)."',
                         '".$vlrVenda."',
                         '".$vlrMinimo."',
                         'P',
                         ".filter_input(INPUT_POST, 'codMarca', FILTER_SANITIZE_NUMBER_INT).",
                         'N',
                         $codClienteFinal,
                         ".filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_NUMBER_INT).",
                         '".filter_input(INPUT_POST, 'nroAroPneu', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'tpoProduto', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'codCfop', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'codNcm', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'codIcmsOrigem', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'codIcmsSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'codPisSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                         '".filter_input(INPUT_POST, 'codCofinsSituacaoTributaria', FILTER_SANITIZE_STRING)."')";        
        $result = $this->insertDB("$sql_lista");        
        $result[2] = $codProduto;
        return $result;
    }

    Public Function UpdateProduto(){
        $vlrVenda = str_replace('.', '', filter_input(INPUT_POST, 'vlrVenda', FILTER_SANITIZE_STRING));
        $vlrVenda = str_replace(',', '.', $vlrVenda);
        $vlrMinimo = str_replace('.', '', filter_input(INPUT_POST, 'vlrMinimo', FILTER_SANITIZE_STRING));
        $vlrMinimo = str_replace(',', '.', $vlrMinimo);
        $sql_lista =
         "UPDATE EN_PRODUTO
             SET DSC_PRODUTO='".filter_input(INPUT_POST, 'dscProduto', FILTER_SANITIZE_STRING)."',
                 COD_MARCA = ".filter_input(INPUT_POST, 'codMarca', FILTER_SANITIZE_NUMBER_INT).",
                 COD_TIPO_PRODUTO = ".filter_input(INPUT_POST, 'codTipoProduto', FILTER_SANITIZE_NUMBER_INT).",
                 VLR_PRODUTO = '".$vlrVenda."',
                 VLR_MINIMO = '".$vlrMinimo."',
                 NRO_ARO_PNEU = '".filter_input(INPUT_POST, 'nroAroPneu', FILTER_SANITIZE_STRING)."',
                 IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                 IND_TIPO_PRODUTO = '".filter_input(INPUT_POST, 'tpoProduto', FILTER_SANITIZE_STRING)."',
                 COD_CFOP = '".filter_input(INPUT_POST, 'codCfop', FILTER_SANITIZE_STRING)."',
                 COD_NCM = '".filter_input(INPUT_POST, 'codNcm', FILTER_SANITIZE_STRING)."',
                 COD_ICMS_ORIGEM = '".filter_input(INPUT_POST, 'codIcmsOrigem', FILTER_SANITIZE_STRING)."',
                 COD_ICMS_SITUACAO_TRIBUTARIA = '".filter_input(INPUT_POST, 'codIcmsSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                 COD_PIS_SITUACAO_TRIBUTARIA = '".filter_input(INPUT_POST, 'codPisSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                 COD_COFINS_SITUACAO_TRIBUTARIA = '".filter_input(INPUT_POST, 'codCofinsSituacaoTributaria', FILTER_SANITIZE_STRING)."'
           WHERE COD_PRODUTO = ".filter_input(INPUT_POST, 'codProduto', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        $result[2] = filter_input(INPUT_POST, 'codProduto', FILTER_SANITIZE_NUMBER_INT);
        return $result;
    }

    Public Function ListarProdutosVendasAutoComplete($codClienteFinal){
        $sql = "SELECT id,
                       COD_PRODUTO,
                       label,
                       value,
                       DSC_PRODUTO,
                       NRO_SEQUENCIAL,
                       IND_TIPO_PRODUTO,                    
                       VLR_VENDA,
                       TPO_PRODUTO,
                       TIPO,
                       DSC_MARCA,
                       VLR_MINIMO,
                       QTD_ESTOQUE
                  FROM (
                SELECT CONCAT(P.COD_PRODUTO,'e',COALESCE(EE.NRO_SEQUENCIAL,'0')) as id,
                    P.COD_PRODUTO,
                    CONCAT(P.DSC_PRODUTO, ' Marca: ', M.DSC_MARCA, CASE WHEN IND_TIPO_PRODUTO = 'S' THEN 'Semi-Novo' WHEN IND_TIPO_PRODUTO = 'N' THEN 'Novo'
                    ELSE '' END,' Valor: ',COALESCE(VLR_VENDA,0),' Estoque: ',COALESCE(QTD_ESTOQUE,0)) AS label,
                    P.DSC_PRODUTO as value,
                    P.DSC_PRODUTO,
                    EE.NRO_SEQUENCIAL,
                    CASE WHEN IND_TIPO_PRODUTO = 'S' THEN 'Semi-Novo' 
                         WHEN IND_TIPO_PRODUTO = 'N' THEN 'Novo'
                    ELSE '' END AS IND_TIPO_PRODUTO,                    
                    CASE WHEN TPO_PRODUTO = 'S' THEN P.VLR_PRODUTO 
                         WHEN TPO_PRODUTO = 'P' AND COALESCE(SUM(COALESCE(E.QTD_ESTOQUE,0)),0) > 0 THEN EE.VLR_VENDA
                    ELSE P.VLR_PRODUTO END AS VLR_VENDA,
                    CASE P.TPO_PRODUTO WHEN 'P' THEN 'PRODUTO' ELSE 'SERVIÇO' END AS TPO_PRODUTO,
                    P.TPO_PRODUTO AS TIPO,
                    COALESCE(M.DSC_MARCA, 'Serviço') AS DSC_MARCA,
                    COALESCE(EE.VLR_MINIMO,0) AS VLR_MINIMO,
                    SUM(COALESCE(E.QTD_ESTOQUE,0)) AS QTD_ESTOQUE
               FROM EN_PRODUTO P
               LEFT JOIN EN_MARCA M
                 ON P.COD_MARCA = M.COD_MARCA
               LEFT JOIN EN_ESTOQUE E
                 ON P.COD_PRODUTO = E.COD_PRODUTO
                AND E.QTD_ESTOQUE > 0
               LEFT JOIN EN_ENTRADA_ESTOQUE EE
                 ON E.COD_PRODUTO = EE.COD_PRODUTO
                AND E.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL  
              WHERE P.COD_CLIENTE_FINAL = $codClienteFinal
                AND DSC_PRODUTO LIKE '%".filter_input(INPUT_POST, 'term', FILTER_SANITIZE_STRING)."%'
                AND P.IND_ATIVO = 'S'
                AND E.QTD_ESTOQUE > 0
                AND P.TPO_PRODUTO = 'P'
              GROUP BY DSC_PRODUTO, M.DSC_MARCA, NRO_SEQUENCIAL
              UNION
              SELECT CONCAT(P.COD_PRODUTO,'e0') as id,
                    P.COD_PRODUTO,
                    CONCAT(P.DSC_PRODUTO, ' Marca: Serviço', ' Valor: ',COALESCE(P.VLR_PRODUTO,0)) AS label,
                    P.DSC_PRODUTO as value,
                    P.DSC_PRODUTO,
                    0 AS NRO_SEQUENCIAL,
                    'Serviço' as IND_TIPO_PRODUTO,                    
                    P.VLR_PRODUTO AS VLR_VENDA,
                    'SERVIÇO' AS TPO_PRODUTO,
                    P.TPO_PRODUTO AS TIPO,
                    'Serviço' AS DSC_MARCA,
                    0 AS VLR_MINIMO,
                    0 AS QTD_ESTOQUE
               FROM EN_PRODUTO P
              WHERE P.COD_CLIENTE_FINAL = $codClienteFinal
                AND DSC_PRODUTO LIKE '%".filter_input(INPUT_POST, 'term', FILTER_SANITIZE_STRING)."%'
                AND P.IND_ATIVO = 'S'
                AND P.TPO_PRODUTO = 'S'
              GROUP BY DSC_PRODUTO) AS X
              ORDER BY DSC_PRODUTO, QTD_ESTOQUE DESC";
//        echo $sql; die;
        return $this->selectDB("$sql", false);
    }

    Public Function ListarProdutosAutoComplete($codClienteFinal){
        $sql = "
             
             SELECT CONCAT(P.COD_PRODUTO,';','0') as id,
                    P.COD_PRODUTO,
                    CONCAT(P.DSC_PRODUTO, ' Marca: ', M.DSC_MARCA, CASE WHEN IND_TIPO_PRODUTO = 'S' THEN 'Semi-Novo' WHEN IND_TIPO_PRODUTO = 'N' THEN 'Novo'
                    ELSE '' END) AS value,                    
                    P.DSC_PRODUTO
               FROM EN_PRODUTO P
               LEFT JOIN EN_MARCA M
                 ON P.COD_MARCA = M.COD_MARCA
              WHERE P.COD_CLIENTE_FINAL = $codClienteFinal
                AND DSC_PRODUTO LIKE '%".filter_input(INPUT_POST, 'term', FILTER_SANITIZE_STRING)."%'
                AND P.TPO_PRODUTO = 'P'
                AND P.IND_ATIVO = 'S'
              GROUP BY P.COD_PRODUTO, P.DSC_PRODUTO
              ORDER BY DSC_PRODUTO DESC";  
        return $this->selectDB("$sql", false);
    }

    /**
     * Verifica se tem outro produto inserido no estoque
     * @param int $codProduto
     * @param int $qtdNecessaria
     * @return int
     */
    Public Function PegaSequencialEstoque ($codProduto,
                                           $qtdNecessaria){
        $sql = "
         SELECT E.NRO_SEQUENCIAL
           FROM EN_ESTOQUE E
          WHERE E.COD_PRODUTO = $codProduto
            AND E.QTD_ESTOQUE>= $qtdNecessaria";
        $lista = $this->selectDB("$sql", false);
        return $lista;
    }
}
?>
