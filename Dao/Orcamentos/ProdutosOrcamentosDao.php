<?php
include_once("../../Dao/BaseDao.php");
class ProdutosOrcamentosDao extends BaseDao
{
    Public Function ProdutosOrcamentosDao(){
        $this->conect();
    }
    /**
     * Retorna os dados de uma determinada venda.
     * Utilizado em ProdutosOrcamentosModel
     * @param Integer $codVenda
     * @return Object
     */
    Public Function ListarDadosProdutosVenda(){
        $sql_lista = "SELECT VP.COD_PRODUTO,
                                DSC_PRODUTO,
                                NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                                COALESCE(VP.VLR_VENDA,0) AS VLR_VENDA,
                                QTD_VENDIDA,
                                VP.VLR_DESCONTO,
                                VP.NRO_SEQUENCIAL,
                                IND_ESTOQUE,
                                VP.COD_VENDA,
                                V.NRO_STATUS_VENDA,
                                E.QTD_ESTOQUE
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
                            WHERE VP.COD_VENDA= ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
            return $this->selectDB("$sql_lista", false);
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
            $sql = "INSERT INTO RE_VENDA_PRODUTO (
                    COD_VENDA,
                    NRO_SEQUENCIAL,
                    COD_PRODUTO,
                    VLR_VENDA,
                    QTD_VENDIDA,
                    VLR_DESCONTO,
                    COD_FUNCIONARIO,
                    IND_ESTOQUE,
                    DTA_VENDA_PRODUTO)
                    VALUES(
                    ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT).", 
                    ".filter_input(INPUT_POST, 'nroSequencialVenda', FILTER_SANITIZE_NUMBER_INT).",
                    ".filter_input(INPUT_POST, 'codProdutoVenda', FILTER_SANITIZE_NUMBER_INT).",
                    '".$vlrVenda."',
                    ".filter_input(INPUT_POST, 'qtdVenda', FILTER_SANITIZE_NUMBER_INT).", 
                    '".$vlrdesconto."', 
                    ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT).", 
                    '".filter_input(INPUT_POST, 'indEstoqueVenda', FILTER_SANITIZE_STRING)."',
                    NOW())";
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
                                E.QTD_ESTOQUE
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
            //echo $sql_lista; exit;
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
            $lista = $this->selectDB("$sql_lista", false);
            if ($lista[1][0]['COD_VENDA']!=0){
                return true;
            }else{
                return false;
            }
    }
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
