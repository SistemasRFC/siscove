<?php
include_once("../../Dao/BaseDao.php");
class FornecedorDao extends BaseDao
{
    function FornecedorDao(){
        $this->conect();
    }

    Public Function ListarFornecedorGrid($codClienteFinal){
        $sql_lista = "SELECT COD_FORNECEDOR,
                            DSC_FORNECEDOR,
                            NRO_TELEFONE,
                            TXT_OBS,
                            IND_ATIVO,
                            NRO_CNPJ,
                            NRO_IE,
                            NRO_CEP,
                            TXT_LOGRADOURO,
                            TXT_COMPLEMENTO,
                            NME_BAIRRO,
                            TXT_LOCALIDADE,
                            SGL_UF
                        FROM EN_FORNECEDOR
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal
                       ORDER BY DSC_FORNECEDOR";
        return $this->selectDB("$sql_lista", false);
    }   

    Public Function ListarFornecedorAtivo($codClienteFinal){
        $sql_lista = "SELECT COD_FORNECEDOR,
                            DSC_FORNECEDOR,
                            NRO_TELEFONE,
                            TXT_OBS,
                            NRO_CNPJ,
                            NRO_IE,
                            NRO_CEP,
                            TXT_LOGRADOURO,
                            TXT_COMPLEMENTO,
                            NME_BAIRRO,
                            TXT_LOCALIDADE,
                            SGL_UF
                        FROM EN_FORNECEDOR
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal
                         AND IND_ATIVO = 'S'
                       ORDER BY DSC_FORNECEDOR";
        return $this->selectDB("$sql_lista", false);
    }   
    
    Public Function AddFornecedor($codClienteFinal){
        $sql_lista = "
        INSERT INTO EN_FORNECEDOR (COD_FORNECEDOR, DSC_FORNECEDOR, NRO_TELEFONE, TXT_OBS, COD_CLIENTE_FINAL, IND_ATIVO, NRO_CNPJ, NRO_IE,
                            NRO_CEP,
                            TXT_LOGRADOURO,
                            TXT_COMPLEMENTO,
                            NME_BAIRRO,
                            TXT_LOCALIDADE,
                            SGL_UF)
        VALUES(".$this->CatchUltimoCodigo('EN_FORNECEDOR', 'COD_FORNECEDOR').",
                                        '".filter_input(INPUT_POST, 'dscFornecedor', FILTER_SANITIZE_STRING)."',
                                        '".filter_input(INPUT_POST, 'nroTelefone', FILTER_SANITIZE_STRING)."',
                                        '".filter_input(INPUT_POST, 'txtObs', FILTER_SANITIZE_STRING)."',
                                        $codClienteFinal,
                                        '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                                        '".filter_input(INPUT_POST, 'nroCNPJ', FILTER_SANITIZE_STRING)."',
                                        '".filter_input(INPUT_POST, 'nroIE', FILTER_SANITIZE_STRING)."',
                                        '".filter_input(INPUT_POST, 'nroCep', FILTER_SANITIZE_STRING)."', 
                                        '".filter_input(INPUT_POST, 'txtLogradouro', FILTER_SANITIZE_STRING)."', 
                                        '".filter_input(INPUT_POST, 'txtComplemento', FILTER_SANITIZE_STRING)."', 
                                        '".filter_input(INPUT_POST, 'nmeBairro', FILTER_SANITIZE_STRING)."', 
                                        '".filter_input(INPUT_POST, 'nmeCidade', FILTER_SANITIZE_STRING)."', 
                                        '".filter_input(INPUT_POST, 'sglUf', FILTER_SANITIZE_STRING)."')";
        return $this->insertDB("$sql_lista");

    }

    Public Function UpdateFornecedor(){
        $sql_lista = 
         "UPDATE EN_FORNECEDOR 
             SET DSC_FORNECEDOR='".filter_input(INPUT_POST, 'dscFornecedor', FILTER_SANITIZE_STRING)."',
                 TXT_OBS = '".filter_input(INPUT_POST, 'txtObs', FILTER_SANITIZE_STRING)."',
                 NRO_TELEFONE = '".filter_input(INPUT_POST, 'nroTelefone', FILTER_SANITIZE_STRING)."',
                 IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."',
                 NRO_CNPJ = '".filter_input(INPUT_POST, 'nroCNPJ', FILTER_SANITIZE_STRING)."',
                 NRO_IE = '".filter_input(INPUT_POST, 'nroIE', FILTER_SANITIZE_STRING)."',
                 NRO_CEP = '".filter_input(INPUT_POST, 'nroCep', FILTER_SANITIZE_STRING)."',
                 TXT_LOGRADOURO = '".filter_input(INPUT_POST, 'txtLogradouro', FILTER_SANITIZE_STRING)."',
                 TXT_COMPLEMENTO = '".filter_input(INPUT_POST, 'txtComplemento', FILTER_SANITIZE_STRING)."',
                 NME_BAIRRO = '".filter_input(INPUT_POST, 'nmeBairro', FILTER_SANITIZE_STRING)."',
                 TXT_LOCALIDADE = '".filter_input(INPUT_POST, 'nmeCidade', FILTER_SANITIZE_STRING)."',
                 SGL_UF = '".filter_input(INPUT_POST, 'sglUf', FILTER_SANITIZE_STRING)."'
           WHERE COD_FORNECEDOR = ".filter_input(INPUT_POST, 'codFornecedor', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

}
?>
