<?php
include_once("../../Dao/BaseDao.php");
class EntradaEstoqueProdutoDao extends BaseDao
{
    Public Function EntradaEstoqueProdutoDao(){
        $this->conect();
    }

    Public Function ListarDadosProdutosEntrada($nroSequencial=NULL){
        $nroSequencial = $nroSequencial==NULL?filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_STRING):$nroSequencial;
        $sql_lista = "SELECT EE.COD_PRODUTO,
                             P.DSC_PRODUTO,
                             M.DSC_MARCA,
                             EE.QTD_ENTRADA,
                             EE.VLR_UNITARIO,
                             EE.VLR_MINIMO,
                             EE.VLR_VENDA,
                             EE.NRO_SEQUENCIAL
                        FROM EN_ENTRADA_ESTOQUE EE
                       INNER JOIN EN_PRODUTO P
                          ON EE.COD_PRODUTO = P.COD_PRODUTO
                        LEFT JOIN EN_MARCA M
                          ON P.COD_MARCA = M.COD_MARCA
                       WHERE EE.NRO_SEQUENCIAL = ".$nroSequencial;
        return $this->selectDB("$sql_lista", false);
    }

    Public Function InserirProduto($nroSequencial=NULL, $codProduto=NULL, $vlrCustoUnitario=NULL, $vlrMinimo=NULL, $vlrVenda=NULL, $qtdEntrada=NULL){
        $nroSequencial = $nroSequencial==NULL?filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT):$nroSequencial;
        $codProduto = $codProduto==NULL?filter_input(INPUT_POST, 'codProdutoEstoque', FILTER_SANITIZE_NUMBER_INT):$codProduto;
        $vlrCustoUnitario = $vlrCustoUnitario==NULL?filter_input(INPUT_POST, 'vlrCustoUnitario', FILTER_SANITIZE_STRING):$vlrCustoUnitario;
        $vlrMinimo = $vlrMinimo==NULL?filter_input(INPUT_POST, 'vlrMinimo', FILTER_SANITIZE_STRING):$vlrMinimo;
        $vlrVenda = $vlrVenda==NULL?filter_input(INPUT_POST, 'vlrVenda', FILTER_SANITIZE_STRING):$vlrVenda;
        $qtdEntrada = $qtdEntrada==NULL?filter_input(INPUT_POST, 'qtdEntrada', FILTER_SANITIZE_NUMBER_INT):$qtdEntrada;
        $vlrCustoUnitario = str_replace('.', '', $vlrCustoUnitario);
        $vlrCustoUnitario = str_replace(',', '.', $vlrCustoUnitario);
        $vlrMinimo = str_replace('.', '', $vlrMinimo);
        $vlrMinimo = str_replace(',', '.', $vlrMinimo);
        $vlrVenda = str_replace('.', '', $vlrVenda);
        $vlrVenda = str_replace(',', '.', $vlrVenda);
        if (!$this->VerificaEntradaProduto($nroSequencial)){
            $sql = "INSERT INTO EN_ENTRADA_ESTOQUE (
                    NRO_SEQUENCIAL,
                    COD_PRODUTO,
                    DTA_ENTRADA_PRODUTO,
                    QTD_ENTRADA,
                    VLR_UNITARIO,
                    VLR_MINIMO,
                    VLR_VENDA)
                    VALUES(
                    ".$nroSequencial.", ".
                    $codProduto.", ".
                    "NOW(), ".
                    $qtdEntrada.", ".
                    "'".$vlrCustoUnitario."', ".
                    "'".$vlrMinimo."', ".
                    "'".$vlrVenda."')";
            $result = $this->insertDB($sql);
//            if ($result[0]){
//                $result = $this->AtualizaEstoque('ADD', filter_input(INPUT_POST, 'qtdEntrada', FILTER_SANITIZE_STRING));
//            }            
        }else{
            $result[0] =  false;
            $result[1] = 'Produto já foi cadastrado!';
        }
       
        return $result;
    }

    Public Function BaixaEstoque($nroSequencial=NULL, $codProduto=NULL, $qtdBaixa=NULL, $txtBaixa=NULL){
        $nroSequencial = $nroSequencial==NULL?filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT):$nroSequencial;
        $codProduto = $codProduto==NULL?filter_input(INPUT_POST, 'codProdutoEstoque', FILTER_SANITIZE_NUMBER_INT):$codProduto;
        $qtdBaixa = $qtdBaixa==NULL?filter_input(INPUT_POST, 'qtdBaixa', FILTER_SANITIZE_STRING):$qtdBaixa;
        $txtBaixa = $txtBaixa==NULL?filter_input(INPUT_POST, 'txtBaixa', FILTER_SANITIZE_STRING):$txtBaixa;
        $sql = "INSERT INTO EN_BAIXA_ESTOQUE (
                NRO_SEQUENCIAL,
                COD_PRODUTO,
                DTA_BAIXA,
                QTD_BAIXA,
                TXT_BAIXA)
                VALUES(
                ".$nroSequencial.", ".
                $codProduto.", ".
                "NOW(), ".
                "'".$qtdBaixa."', ".
                "'".$txtBaixa."')";
        if($this->insertDB("$sql")){
            return $this->AtualizaEstoque('REMOVE', 
                                          $qtdBaixa,
                                          $codProduto,
                                          $nroSequencial);
        }else{
            return false;
        }
    }

    Public Function DeletarProdutoEntrada($nroSequencial=NULL, $codProduto=NULL){
        $nroSequencial = $nroSequencial==NULL?filter_input(INPUT_POST, 'nroSequencial', FILTER_SANITIZE_NUMBER_INT):$nroSequencial;
        $codProduto = $codProduto==NULL?filter_input(INPUT_POST, 'codProdutoEstoque', FILTER_SANITIZE_NUMBER_INT):$codProduto;
        $sql = "DELETE FROM EN_ENTRADA_ESTOQUE
                 WHERE NRO_SEQUENCIAL = ".$nroSequencial."
                   AND COD_PRODUTO = ".$codProduto;
        $return = $this->insertDB("$sql");
        return $return;
    }

    Public Function VerificaEntradaProduto($nroSequencial){
        $sql_lista = "SELECT NRO_SEQUENCIAL
                        FROM EN_ENTRADA_ESTOQUE
                        WHERE NRO_SEQUENCIAL=".$nroSequencial."
                          AND COD_PRODUTO=".filter_input(INPUT_POST, 'codProdutoEstoque', FILTER_SANITIZE_NUMBER_INT);
        $lista = $this->selectDB("$sql_lista", true);        
        if ($lista[1]!=null){
            return true;
        }else{
            return false;
        }
    }

    Public Function AtualizaEstoque($indOperacao, $qtdAtualizar, $codProduto, $nroSequencial){
        $sql_verifica = "SELECT COD_PRODUTO, QTD_ESTOQUE
                           FROM EN_ESTOQUE WHERE COD_PRODUTO = ".$codProduto."
                            AND NRO_SEQUENCIAL = ".$nroSequencial;
        $result = $this->selectDB($sql_verifica, false);
        
        if ($result[0]){
            if ($result[1][0]['QTD_ESTOQUE']!=NULL || $result[1][0]['QTD_ESTOQUE']!=''){
                if ($indOperacao=="ADD"){
                    $qtdAtualiza = $result[1][0]['QTD_ESTOQUE']+$qtdAtualizar;
                }else{
                    $qtdAtualiza = $result[1][0]['QTD_ESTOQUE']-$qtdAtualizar;
                }
                $sql = "UPDATE EN_ESTOQUE SET QTD_ESTOQUE = ".$qtdAtualiza."
                    WHERE COD_PRODUTO=".$codProduto."
                      AND NRO_SEQUENCIAL = ".$nroSequencial;
                $result = $this->insertDB("$sql");
            }else{
                $sql = "INSERT INTO EN_ESTOQUE VALUES(".$codProduto.",".$nroSequencial.",".$qtdAtualizar.")";                
                $result = $this->insertDB("$sql");            
            }
        }
        return $result;
    }

}
?>
