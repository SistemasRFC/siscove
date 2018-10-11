<?php
include_once("../../Dao/BaseDao.php");
class ProdutosVendasDao extends BaseDao
{
    Public Function ProdutosVendasDao(){
        $this->conect();
    }
    /**
     * Retorna os dados de uma determinada venda.
     * Utilizado em ProdutosVendasModel
     * @param Integer $codVenda
     * @return Object
     */
    Public Function ListarDadosProdutosVenda(){
        $sql_lista = "SELECT VP.COD_PRODUTO,
                                DSC_PRODUTO,
                                COALESCE(M.DSC_MARCA, 'Outros') AS DSC_MARCA,
                                NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                                COALESCE(VP.VLR_VENDA,0) AS VLR_VENDA,
                                QTD_VENDIDA,
                                CASE WHEN P.TPO_PRODUTO = 'P' THEN 'Produto'
                                     WHEN P.TPO_PRODUTO = 'S' THEN 'Serviço'
                                     ELSE 'Sem Informação'
                                END AS TPO_PRODUTO,
                                COALESCE(VP.VLR_DESCONTO,0) AS VLR_DESCONTO,
                                VP.NRO_SEQUENCIAL,
                                IND_ESTOQUE,
                                VP.COD_VENDA,
                                V.NRO_STATUS_VENDA,
                                E.QTD_ESTOQUE,
                                VP.TXT_OBSERVACAO,
                                P.COD_CFOP,
                                P.COD_NCM,
                                P.COD_ICMS_ORIGEM,
                                P.COD_ICMS_SITUACAO_TRIBUTARIA,
                                P.COD_PIS_SITUACAO_TRIBUTARIA,
                                P.COD_COFINS_SITUACAO_TRIBUTARIA,
                                IST.DSC_CODIGO AS DSC_CODIGO_ICMS,
                                CST.DSC_CODIGO AS DSC_CODIGO_COFINS,
                                PST.DSC_CODIGO AS DSC_CODIGO_PIS
                            FROM EN_VENDA V
                            INNER JOIN RE_VENDA_PRODUTO VP
                               ON V.COD_VENDA = VP.COD_VENDA
                            INNER JOIN EN_PRODUTO P
                               ON VP.COD_PRODUTO = P.COD_PRODUTO
                             LEFT JOIN EN_ICMS_SITUACAO_TRIBUTARIA IST
                               ON P.COD_ICMS_SITUACAO_TRIBUTARIA = IST.COD_ICMS_SITUACAO_TRIBUTARIA
                             LEFT JOIN EN_COFINS_SITUACAO_TRIBUTARIA CST
                               ON P.COD_COFINS_SITUACAO_TRIBUTARIA = CST.COD_COFINS_SITUACAO_TRIBUTARIA
                             LEFT JOIN EN_PIS_SITUACAO_TRIBUTARIA PST
                               ON P.COD_PIS_SITUACAO_TRIBUTARIA = PST.COD_PIS_SITUACAO_TRIBUTARIA                               
                             LEFT JOIN EN_MARCA M
                               ON P.COD_MARCA = M.COD_MARCA
                            INNER JOIN SE_USUARIO U
                                ON VP.COD_FUNCIONARIO = U.COD_USUARIO
                             LEFT JOIN EN_ESTOQUE E
                               ON VP.COD_PRODUTO = E.COD_PRODUTO
                              AND VP.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
                            WHERE VP.COD_VENDA= ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
//            echo $sql_lista; die;
            return $this->selectDB("$sql_lista", false);
    }

    Public Function VerificaValoresAbaixoMinimo($codVenda){        
        $sql_lista = "SELECT V.COD_VENDA
                        FROM EN_VENDA V
                       INNER JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                       INNER JOIN EN_ENTRADA_ESTOQUE EE
                          ON VP.NRO_SEQUENCIAL = EE.NRO_SEQUENCIAL
                         AND VP.COD_PRODUTO = EE.COD_PRODUTO
                       WHERE VP.VLR_VENDA-VP.VLR_DESCONTO<EE.VLR_MINIMO
                         AND VP.COD_VENDA = $codVenda";
        //echo $sql_lista; exit;
        $lista = $this->selectDB("$sql_lista", false);
        if (empty($lista)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * Insere um produto na venda
     * @return String ("S" ou "N")
     */
    Public Function InserirProduto(){
        if (!$this->VerificaVendaProduto()){
            $vlrdesconto = str_replace('.', '', filter_input(INPUT_POST, 'vlrDesconto', FILTER_SANITIZE_STRING));
            $vlrdesconto = str_replace(',', '.', $vlrdesconto);
            $vlrVenda = str_replace('.', '', filter_input(INPUT_POST, 'vlrVenda', FILTER_SANITIZE_STRING));
            $vlrVenda = str_replace(',', '.', $vlrVenda);
            $qtdVenda = str_replace('.', '', filter_input(INPUT_POST, 'qtdVenda', FILTER_SANITIZE_NUMBER_INT));
            $qtdVenda = str_replace(',', '.', $qtdVenda);
            $sql = "INSERT INTO RE_VENDA_PRODUTO (
                    COD_VENDA,
                    NRO_SEQUENCIAL,
                    COD_PRODUTO,
                    VLR_VENDA,
                    QTD_VENDIDA,
                    VLR_DESCONTO,
                    COD_FUNCIONARIO,
                    IND_ESTOQUE,
                    DTA_VENDA_PRODUTO,
                    TXT_OBSERVACAO)
                    VALUES(
                    ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT).", 
                    ".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT).",
                    ".filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_NUMBER_INT).",
                    '".$vlrVenda."',
                    '".$qtdVenda."', 
                    '".$vlrdesconto."', 
                    ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT).", 
                    '".filter_input(INPUT_POST, 'indEstoqueVenda', FILTER_SANITIZE_STRING)."',
                    NOW(), 
                    '".filter_input(INPUT_POST, 'txtObservacao', FILTER_SANITIZE_STRING)."')";
            $result = $this->insertDB("$sql");
        }else{
            $result[0] = false;
            $result[1] = "Produto Já inserido!";
        }
        return $result;
    }

    /**
     * Deleta um produto da venda
     * @return Boolean
     */
    Public Function DeletarProdutoVenda(){
        $sql = "DELETE FROM RE_VENDA_PRODUTO
                 WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)." AND NRO_SEQUENCIAL = ".
                filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT)." AND COD_PRODUTO = ".
                filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql");
    }

    Public function RegistroProdutoVenda($codUsuario, $tpoOperacao){
            $qtdProduto = str_replace('.', '', filter_input(INPUT_POST, 'qtdVenda', FILTER_SANITIZE_NUMBER_INT));
            $qtdProduto = str_replace(',', '.', $qtdProduto);
            $vlrProduto = str_replace('.', '', filter_input(INPUT_POST, 'vlrVenda', FILTER_SANITIZE_STRING));
            $vlrProduto = str_replace(',', '.', $vlrProduto);
        $sql = "INSERT INTO EN_LOG_VENDA_PRODUTO (COD_VENDA, COD_PRODUTO, QTD_PRODUTO, VLR_PRODUTO, COD_USUARIO, DTA_OPERACAO, TPO_OPERACAO)
                VALUES(".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT).",
                       ".filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_NUMBER_INT).",
                       $qtdProduto,
                       '$vlrProduto',
                       $codUsuario,
                       NOW(),
                       '$tpoOperacao')";
        return $this->insertDB($sql);
    }
    
    /**
     * Retorna uma lista com os produtos de determinada venda
     * @return Array
     */
   Public Function ListarProdutosVenda(){
        try{
            $sql_lista = "SELECT VP.COD_PRODUTO,
                                 DSC_PRODUTO,
                                NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                                VP.VLR_VENDA,
                                QTD_VENDIDA,
                                VP.VLR_DESCONTO,
                                VP.NRO_SEQUENCIAL,
                                IND_ESTOQUE,
                                VP.COD_VENDA,
                                V.NRO_STATUS_VENDA,
                                E.QTD_ESTOQUE,
                                VP.TXT_OBSERVACAO
                            FROM EN_VENDA V
                            INNER JOIN RE_VENDA_PRODUTO VP
                               ON V.COD_VENDA = VP.COD_VENDA
                            INNER JOIN EN_PRODUTO P
                                ON VP.COD_PRODUTO = P.COD_PRODUTO
                            INNER JOIN SE_USUARIO U
                                ON VP.COD_FUNCIONARIO = U.COD_USUARIO
                             LEFT JOIN EN_ESTOQUE E
                               ON VP.COD_PRODUTO = E.COD_PRODUTO
                              AND VP.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
                            WHERE VP.COD_VENDA=".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;        
    }
    
    /**
     * Verifica se o produto já existe na venda
     * @return Boolean
     */
    Public Function VerificaVendaProduto(){       
            $sql_lista = "SELECT COALESCE(COD_VENDA,0) AS COD_VENDA
                            FROM RE_VENDA_PRODUTO
                            WHERE COD_VENDA=".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT)."
                              AND COD_PRODUTO=".filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_NUMBER_INT)."
                              AND NRO_SEQUENCIAL=".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT);
            //echo $sql_lista; die;
            $lista = $this->selectDB("$sql_lista", false);
            if ($lista[1][0]['COD_VENDA']!=0){
                return true;
            }else{
                return false;
            }
    }

    /**
     * Atualiza a tabela de estoque de produtos
     * "ADD" - Adiciona a quantidade no estoque ou "REMOVE" - Remove a quantidade do estoque
     * @param String $indOperacao
     * @param int $codProduto
     * @param int $nroSequencial
     * @param int $qtdMovimentacao
     * @return Boolean
     */
    Public Function AtualizaEstoque($indOperacao, $codProduto, $nroSequencial, $qtdMovimentacao){
        $sql_verifica = "SELECT COD_PRODUTO, QTD_ESTOQUE
                           FROM EN_ESTOQUE WHERE COD_PRODUTO = ".$codProduto."
                            AND NRO_SEQUENCIAL = ".$nroSequencial;
        $ver = $this->selectDB($sql_verifica, false);
        if ($ver[0]){
            if ($indOperacao=="ADD"){
                $qtdAtualiza = $ver[1][0]['QTD_ESTOQUE']+$qtdMovimentacao;
            }else{
                $qtdAtualiza = $ver[1][0]['QTD_ESTOQUE']-$qtdMovimentacao;
            }
            $sql = "UPDATE EN_ESTOQUE SET QTD_ESTOQUE = ".$qtdAtualiza."
                     WHERE COD_PRODUTO=".$codProduto."
                       AND NRO_SEQUENCIAL = ".$nroSequencial;
            return $this->insertDB("$sql");
        }else{
            $qtdAtualiza = $qtdMovimentacao*-1;
            $sql = "INSERT INTO EN_ESTOQUE VALUES(".$codProduto.",".$nroSequencial.",".$qtdAtualiza.")";
            return $this->insertDB("$sql");
        }
    }

    /**
     * Retorna um array de acordo com o produto e o sequencial
     * @param int $nroSequencial
     * @param int $codProduto
     * @return Array(COD_PRODUTO, DSC_PRODUTO, NRO_SEQUENCIAL, VLR_VENDA, TPO_PRODUTO, TIPO, DSC_MARCA, VLR_MINIMO, QTD_ESTOQUE)
     */
    Public Function VerificaEstoqueProduto($nroSequencial,
                                    $codProduto){
        $sql = "
         SELECT P.COD_PRODUTO,
                P.DSC_PRODUTO,
                EE.NRO_SEQUENCIAL,
                CASE TPO_PRODUTO WHEN 'S' THEN P.VLR_PRODUTO ELSE EE.VLR_VENDA END AS VLR_VENDA,
                CASE P.TPO_PRODUTO WHEN 'P' THEN 'PRODUTO' ELSE 'SERVIÇO' END AS TPO_PRODUTO,
                P.TPO_PRODUTO AS TIPO,
                M.DSC_MARCA,
                COALESCE(EE.VLR_MINIMO,0) AS VLR_MINIMO,
                COALESCE(E.QTD_ESTOQUE,0) AS QTD_ESTOQUE
           FROM EN_PRODUTO P
           LEFT JOIN EN_MARCA M
             ON P.COD_MARCA = M.COD_MARCA
           LEFT JOIN EN_ENTRADA_ESTOQUE EE
             ON P.COD_PRODUTO = EE.COD_PRODUTO
           LEFT JOIN EN_ESTOQUE E
             ON EE.COD_PRODUTO = E.COD_PRODUTO
            AND EE.NRO_SEQUENCIAL = E.NRO_SEQUENCIAL
            AND E.QTD_ESTOQUE>0
          WHERE P.COD_PRODUTO = $codProduto
            AND EE.NRO_SEQUENCIAL = $nroSequencial";
        $lista = $this->selectDB("$sql", false);
        return $lista;
    }

    /**
     * Atualiza o indicador de retirada do estoque do produto
     * @param <type> $codVenda
     * @param <type> $nroSequencial
     * @param <type> $codProduto
     */
    Public Function AtualizaProduto($codVenda,
                            $nroSequencial,
                            $codProduto){
        $sql = "UPDATE RE_VENDA_PRODUTO
                   SET IND_ESTOQUE = 'S'
                 WHERE COD_VENDA = ".$codVenda."
                   AND NRO_SEQUENCIAL = $nroSequencial
                   AND COD_PRODUTO = $codProduto";
        $this->insertDB($sql);
    }
}
?>
