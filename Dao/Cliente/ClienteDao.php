<?php
include_once("../../Dao/BaseDao.php");
class ClienteDao extends BaseDao
{
    Public Function ClienteDao(){
        $this->conect();
    }

    Public Function ListarClienteGrid($codClienteFinal){
        $sql_lista = "SELECT COD_CLIENTE,
                          DSC_CLIENTE,
                          IND_TIPO_CLIENTE,
                          NRO_CPF,
                          NRO_CNPJ,
                          NRO_IE,
                          NRO_TELEFONE_CONTATO,
                          NRO_TELEFONE_CELULAR,
                          DTA_NASCIMENTO,
                          NRO_CEP,
                          TXT_LOGRADOURO,
                          TXT_COMPLEMENTO,
                          NME_BAIRRO,
                          TXT_LOCALIDADE,
                          SGL_UF,
                          TXT_UNIDADE,
                          COD_IBGE,
                          COD_GIA,
                          TXT_EMAIL
                     FROM EN_CLIENTE
                    WHERE DSC_CLIENTE LIKE '".filter_input(INPUT_POST, 'parametro', FILTER_SANITIZE_STRING)."%'
                      AND COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function ListarClienteAutoComplete($codClienteFinal){
        $sql_lista = "SELECT COD_CLIENTE as id,
                          DSC_CLIENTE as value,
                          NRO_CPF,
                          NRO_CNPJ,
                          NRO_IE,
                          NRO_TELEFONE_CONTATO,
                          NRO_TELEFONE_CELULAR,
                          NRO_CEP,
                          TXT_LOGRADOURO,
                          TXT_COMPLEMENTO,
                          NME_BAIRRO,
                          TXT_LOCALIDADE,
                          SGL_UF,
                          TXT_UNIDADE,
                          COD_IBGE,
                          COD_GIA,
                          TXT_EMAIL,
                          DTA_NASCIMENTO,
                          TXT_EMAIL
                     FROM EN_CLIENTE
                    WHERE DSC_CLIENTE LIKE '".filter_input(INPUT_POST, 'term', FILTER_SANITIZE_STRING)."%'
                      AND COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarClienteCpfAutoComplete($codClienteFinal){
        $sql_lista = "SELECT COD_CLIENTE as id,
                          DSC_CLIENTE as value,
                          NRO_CPF,
                          NRO_CNPJ,
                          NRO_IE,
                          NRO_TELEFONE_CONTATO,
                          NRO_TELEFONE_CELULAR,
                          NRO_CEP,
                          TXT_LOGRADOURO,
                          TXT_COMPLEMENTO,
                          NME_BAIRRO,
                          TXT_LOCALIDADE,
                          SGL_UF,
                          TXT_UNIDADE,
                          COD_IBGE,
                          COD_GIA,
                          TXT_EMAIL,
                          DTA_NASCIMENTO,
                          TXT_EMAIL
                     FROM EN_CLIENTE
                    WHERE NRO_CPF LIKE '".filter_input(INPUT_POST, 'term', FILTER_SANITIZE_STRING)."%'
                      AND COD_CLIENTE_FINAL = $codClienteFinal";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function ListarEstados(){
        $sql_lista = "SELECT SGL_ESTADO,
                             DSC_ESTADO
                        FROM EN_ESTADO E";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function CarregaDadosCliente(){
        $sql_lista = "SELECT COD_CLIENTE,
                          DSC_CLIENTE,
                          NRO_CPF,
                          NRO_CNPJ,
                          NRO_IE,
                          IND_TIPO_CLIENTE,
                          NRO_CNPJ,
                          NRO_TELEFONE_CONTATO,
                          NRO_TELEFONE_CELULAR,
                          NRO_CEP,
                          TXT_LOGRADOURO,
                          TXT_COMPLEMENTO,
                          NME_BAIRRO,
                          TXT_LOCALIDADE,
                          SGL_UF,
                          TXT_UNIDADE,
                          COD_IBGE,
                          COD_GIA,
                          TXT_EMAIL,
                          DTA_NASCIMENTO,
                          TXT_EMAIL
                     FROM EN_CLIENTE
                    WHERE COD_CLIENTE LIKE ".filter_input(INPUT_POST, 'codCliente', FILTER_SANITIZE_STRING);
        return $this->selectDB("$sql_lista", false);
    }

    Public Function AddCliente($codClienteFinal){
        $this->CatchUltimoCodigo('EN_CLIENTE', 'COD_CLIENTE');
        $codigo = $this->CatchUltimoCodigo('EN_CLIENTE', 'COD_CLIENTE');
        $sql_lista = "
        INSERT INTO EN_CLIENTE(COD_CLIENTE,
                               DSC_CLIENTE,
                               NRO_TELEFONE_CONTATO,
                               NRO_TELEFONE_CELULAR,
                               IND_TIPO_CLIENTE,
                               NRO_CPF,
                               NRO_CNPJ,
                               NRO_IE,
                               COD_CLIENTE_FINAL,
                               DTA_NASCIMENTO,
                               TXT_EMAIL,
                               NRO_CEP,
                               TXT_LOGRADOURO,
                               TXT_COMPLEMENTO,
                               NME_BAIRRO,
                               TXT_LOCALIDADE,
                               SGL_UF,
                               TXT_UNIDADE,
                               COD_IBGE,
                               COD_GIA) 
        VALUES (  ".$codigo.", ".
                  "'".filter_input(INPUT_POST, 'dscCliente', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'foneCelular', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'codTipoPessoa', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'nroCnpj', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'nroIe', FILTER_SANITIZE_STRING)."', ".
                  "".$codClienteFinal.", ".
                  "'".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaNascimento', FILTER_SANITIZE_STRING))."', ".
                  "'".filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'nroCep', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'txtLogradouro', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'txtComplemento', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'nmeBairro', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'nmeCidade', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'sglUf', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'txtUnidade', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'codIbge', FILTER_SANITIZE_STRING)."', ".
                  "'".filter_input(INPUT_POST, 'codGia', FILTER_SANITIZE_STRING)."') ";
        $return = $this->insertDB($sql_lista);
        $return[2] = $codigo;
        return $return;
    }

    Public Function UpdateCliente(){        
        $sql_lista = "
         UPDATE EN_CLIENTE
            SET DSC_CLIENTE='".filter_input(INPUT_POST, 'dscCliente', FILTER_SANITIZE_STRING)."',
                NRO_TELEFONE_CONTATO = '".filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING)."',
                NRO_TELEFONE_CELULAR = '".filter_input(INPUT_POST, 'foneCelular', FILTER_SANITIZE_STRING)."',
                IND_TIPO_CLIENTE = '".filter_input(INPUT_POST, 'codTipoPessoa', FILTER_SANITIZE_STRING)."',
                NRO_CPF = '".filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_STRING)."',
                NRO_CNPJ = '".filter_input(INPUT_POST, 'nroCnpj', FILTER_SANITIZE_STRING)."',
                NRO_IE = '".filter_input(INPUT_POST, 'nroIe', FILTER_SANITIZE_STRING)."',
                DTA_NASCIMENTO = '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaNascimento', FILTER_SANITIZE_STRING))."',
                TXT_EMAIL = '".filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_STRING)."',
                NRO_CEP = '".filter_input(INPUT_POST, 'nroCep', FILTER_SANITIZE_STRING)."',
                TXT_LOGRADOURO = '".filter_input(INPUT_POST, 'txtLogradouro', FILTER_SANITIZE_STRING)."',
                TXT_COMPLEMENTO = '".filter_input(INPUT_POST, 'txtComplemento', FILTER_SANITIZE_STRING)."',
                NME_BAIRRO = '".filter_input(INPUT_POST, 'nmeBairro', FILTER_SANITIZE_STRING)."',
                TXT_LOCALIDADE = '".filter_input(INPUT_POST, 'nmeCidade', FILTER_SANITIZE_STRING)."',
                SGL_UF = '".filter_input(INPUT_POST, 'sglUf', FILTER_SANITIZE_STRING)."',
                TXT_UNIDADE = '".filter_input(INPUT_POST, 'txtUnidade', FILTER_SANITIZE_STRING)."',
                COD_IBGE = '".filter_input(INPUT_POST, 'codIbge', FILTER_SANITIZE_STRING)."',
                COD_GIA = '".filter_input(INPUT_POST, 'codGia', FILTER_SANITIZE_STRING)."'
          WHERE COD_CLIENTE = ".filter_input(INPUT_POST, 'codCliente', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");    
        $result[2] = filter_input(INPUT_POST, 'codCliente', FILTER_SANITIZE_NUMBER_INT);
        return $result;

    }

    Public Function VerificaCPF(){
        $sql_lista = "SELECT COALESCE(COD_CLIENTE,0) AS COD_CLIENTE
                     FROM EN_CLIENTE
                    WHERE NRO_CPF = '".filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_STRING)."'
                      AND COD_CLIENTE <> ".filter_input(INPUT_POST, 'codCliente', FILTER_SANITIZE_NUMBER_INT);
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function VendasCliente($codCliente){
        $sql = "SELECT COD_VENDA
                  FROM EN_VENDA
                 WHERE COD_CLIENTE = ".$codCliente;
        return $this->selectDB($sql, false);
    }
    
    Public Function DeleteCliente($codCliente){
        $sql = "DELETE FROM EN_CLIENTE WHERE COD_CLIENTE = ".$codCliente;
        return $this->insertDB($sql);
    }
    
    Public Function ListarVendasPorCliente(){
        $sql_lista = "SELECT V.COD_VENDA,
                            C.DSC_CLIENTE,
                            DTA_VENDA,
                            CONCAT('Mês: ',MONTH(DTA_VENDA), ' Ano: ',YEAR(DTA_VENDA)) AS MES_ANO,
                            COALESCE(VP.VLR_VENDA,0) AS VLR_VENDA_UNITARIA,
                            COALESCE(VP.VLR_DESCONTO,0) AS VLR_DESCONTO,
                            VP.QTD_VENDIDA AS QTD_VENDIDA,
                            (COALESCE(VP.VLR_VENDA,0)-(COALESCE(VP.VLR_DESCONTO,0)))*VP.QTD_VENDIDA AS VLR_VENDA,
                            V.NRO_PLACA,
                            V.DSC_VEICULO,
                            P.DSC_PRODUTO
                       FROM EN_VENDA V
                       LEFT JOIN EN_CLIENTE C
                         ON V.COD_CLIENTE = C.COD_CLIENTE
                       LEFT JOIN EN_VEICULOS VC
                         ON V.COD_VEICULO = VC.COD_VEICULO
                       LEFT JOIN RE_VENDA_PRODUTO VP
                         ON V.COD_VENDA = VP.COD_VENDA
                       LEFT JOIN EN_PRODUTO P
                         ON VP.COD_PRODUTO = P.COD_PRODUTO
                       LEFT JOIN SE_USUARIO U
                         ON V.COD_USUARIO = U.COD_USUARIO
                      WHERE V.COD_CLIENTE = '".filter_input(INPUT_POST, 'codClienteVenda', FILTER_SANITIZE_STRING)."'
                      ORDER BY DTA_VENDA";
        return $this->selectDB("$sql_lista", false);
    }

}
?>
