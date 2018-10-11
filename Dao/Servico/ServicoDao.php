<?php
include_once("../../Dao/BaseDao.php");
class ServicoDao extends BaseDao
{
    Public Function ServicoDao(){
        $this->conect();
    }
    
    Public Function ListarServico($codClienteFinal){
        $sql_lista = "
                 SELECT COD_PRODUTO,
                        DSC_PRODUTO,
                        VLR_PRODUTO,
                        VLR_MINIMO,
                        IND_ATIVO,
                        VLR_PORCENTAGEM,
                        IND_COMISSAO_GERENCIA,
                        P.COD_CFOP,
                        N.COD_CATEGORIA_NCM,
                        P.COD_NCM,
                        P.COD_ICMS_ORIGEM,
                        P.COD_ICMS_SITUACAO_TRIBUTARIA,
                        P.COD_PIS_SITUACAO_TRIBUTARIA,
                        P.COD_COFINS_SITUACAO_TRIBUTARIA
                   FROM EN_PRODUTO P
                   LEFT JOIN EN_NCM N
                     ON P.COD_NCM = N.COD_NCM
                  WHERE DSC_PRODUTO LIKE '".filter_input(INPUT_POST, 'parametro', FILTER_SANITIZE_STRING)."%'
                    AND TPO_PRODUTO = 'S'
                    AND P.COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarServicosAtivos($codClienteFinal){
        $sql_lista = "SELECT COD_PRODUTO,
                             DSC_PRODUTO,
                             VLR_PRODUTO,
                             VLR_MINIMO,
                             VLR_PORCENTAGEM,
                             IND_COMISSAO_GERENCIA
                        FROM EN_PRODUTO
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal 
                         AND IND_ATIVO='S'";
        return $this->selectDB("$sql_lista", false);
    }

    function AddServico($codClienteFinal){ 
        $vlrServico = str_replace('.', '', filter_input(INPUT_POST, 'vlrServico', FILTER_SANITIZE_STRING));
        $vlrServico = str_replace(',', '.', $vlrServico);    
        $vlrMinimo = str_replace('.', '', filter_input(INPUT_POST, 'vlrMinimo', FILTER_SANITIZE_STRING));
        $vlrMinimo = str_replace(',', '.', $vlrMinimo);     
        $vlrPorcentagem = str_replace('.', '', filter_input(INPUT_POST, 'vlrPorcentagem', FILTER_SANITIZE_STRING));
        $vlrPorcentagem = str_replace(',', '.', $vlrPorcentagem);                
        $sql_lista = "
                 INSERT INTO EN_PRODUTO (COD_PRODUTO, DSC_PRODUTO, VLR_PRODUTO, VLR_MINIMO,
                                         TPO_PRODUTO, COD_MARCA, IND_ALINHAMENTO, 
                                         COD_CLIENTE_FINAL, IND_ATIVO, VLR_PORCENTAGEM, IND_COMISSAO_GERENCIA,
                                         COD_CFOP, COD_NCM, COD_ICMS_ORIGEM, COD_ICMS_SITUACAO_TRIBUTARIA, COD_PIS_SITUACAO_TRIBUTARIA, COD_COFINS_SITUACAO_TRIBUTARIA)
                 VALUES(".$this->CatchUltimoCodigo('EN_PRODUTO', 'COD_PRODUTO').",
                                               '".filter_input(INPUT_POST, 'dscServico', FILTER_SANITIZE_STRING)."',
                                               '".$vlrServico."',
                                               '".$vlrMinimo."',
                                               'S',
                                               0,
                                               'N',
                                               $codClienteFinal,
                                               '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                                               '".$vlrPorcentagem."',
                                               '".filter_input(INPUT_POST, 'indComissaoGerencia', FILTER_SANITIZE_STRING)."',
                                               '".filter_input(INPUT_POST, 'codCfop', FILTER_SANITIZE_STRING)."',
                                               '".filter_input(INPUT_POST, 'codNcm', FILTER_SANITIZE_STRING)."',
                                               '".filter_input(INPUT_POST, 'codIcmsOrigem', FILTER_SANITIZE_STRING)."',
                                               '".filter_input(INPUT_POST, 'codIcmsSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                                               '".filter_input(INPUT_POST, 'codPisSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                                               '".filter_input(INPUT_POST, 'codCofinsSituacaoTributaria', FILTER_SANITIZE_STRING)."')";
        return $this->insertDB("$sql_lista");

    }

    function UpdateServico(){
        $vlrServico = str_replace('.', '', filter_input(INPUT_POST, 'vlrServico', FILTER_SANITIZE_STRING));
        $vlrServico = str_replace(',', '.', $vlrServico);   
        $vlrMinimo = str_replace('.', '', filter_input(INPUT_POST, 'vlrMinimo', FILTER_SANITIZE_STRING));
        $vlrMinimo = str_replace(',', '.', $vlrMinimo);  
        $vlrPorcentagem = str_replace('.', '', filter_input(INPUT_POST, 'vlrPorcentagem', FILTER_SANITIZE_STRING));
        $vlrPorcentagem = str_replace(',', '.', $vlrPorcentagem);        
        $sql_lista =
         "UPDATE EN_PRODUTO
             SET DSC_PRODUTO='".filter_input(INPUT_POST, 'dscServico', FILTER_SANITIZE_STRING)."',
                 VLR_PRODUTO = '".$vlrServico."',
                 VLR_MINIMO = '".$vlrMinimo."',
                 IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                 VLR_PORCENTAGEM = '".$vlrPorcentagem."',
                 IND_COMISSAO_GERENCIA = '".filter_input(INPUT_POST, 'indComissaoGerencia', FILTER_SANITIZE_STRING)."',
                 COD_CFOP = '".filter_input(INPUT_POST, 'codCfop', FILTER_SANITIZE_STRING)."',
                 COD_NCM = '".filter_input(INPUT_POST, 'codNcm', FILTER_SANITIZE_STRING)."',
                 COD_ICMS_ORIGEM = '".filter_input(INPUT_POST, 'codIcmsOrigem', FILTER_SANITIZE_STRING)."',
                 COD_ICMS_SITUACAO_TRIBUTARIA = '".filter_input(INPUT_POST, 'codIcmsSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                 COD_PIS_SITUACAO_TRIBUTARIA = '".filter_input(INPUT_POST, 'codPisSituacaoTributaria', FILTER_SANITIZE_STRING)."',
                 COD_COFINS_SITUACAO_TRIBUTARIA = '".filter_input(INPUT_POST, 'codCofinsSituacaoTributaria', FILTER_SANITIZE_STRING)."'
           WHERE COD_PRODUTO = ".filter_input(INPUT_POST, 'codServico', FILTER_SANITIZE_NUMBER_INT);
        return $this->insertDB("$sql_lista");

    }
}
?>
