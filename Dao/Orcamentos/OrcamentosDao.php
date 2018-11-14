<?php
include_once("../../Dao/BaseDao.php");
class OrcamentosDao extends BaseDao
{
    Public Function OrcamentosDao(){
        $this->conect();
    }

    Public Function ListarOrcamentosAberto($codClienteFinal){
        $sql_lista = "SELECT V.COD_VENDA,
                            C.DSC_CLIENTE,
                            U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                            DTA_VENDA,
                            CONCAT('Mês: ',MONTH(DTA_VENDA), ' Ano: ',YEAR(DTA_VENDA)) AS MES_ANO,
                            CONCAT('Mês: ',MONTH(DTA_VENDA),' do ano ',YEAR(DTA_VENDA)) AS MES_ANO_BARRA,
                            SUM((COALESCE(VP.VLR_VENDA,0)-(COALESCE(VP.VLR_DESCONTO,0)))*VP.QTD_VENDIDA) AS VLR_VENDA,
                            V.NRO_PLACA,
                            VC.COD_VEICULO,
                            V.COD_USUARIO,
                            V.COD_CLIENTE,
                            V.DSC_VEICULO,
                            COALESCE(V.TXT_OBSERVACAO,'') AS TXT_OBSERVACAO,
                            C.NRO_TELEFONE_CONTATO,
                            C.NRO_TELEFONE_CELULAR,
                            C.NRO_CPF,
                            C.TXT_LOGRADOURO,
                            C.NRO_CNPJ
                       FROM EN_VENDA V
                       LEFT JOIN EN_CLIENTE C
                         ON V.COD_CLIENTE = C.COD_CLIENTE
                       LEFT JOIN EN_VEICULOS VC
                         ON V.COD_VEICULO = VC.COD_VEICULO
                       LEFT JOIN RE_VENDA_PRODUTO VP
                         ON V.COD_VENDA = VP.COD_VENDA
                       LEFT JOIN SE_USUARIO U
                         ON V.COD_USUARIO = U.COD_USUARIO
                      WHERE V.NRO_STATUS_VENDA = 'O'
                        AND V.COD_CLIENTE_FINAL = $codClienteFinal
                      GROUP BY V.COD_VENDA,
                               C.DSC_CLIENTE,
                               U.NME_USUARIO_COMPLETO,
                               V.DTA_VENDA
                      ORDER BY V.DTA_VENDA DESC";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function ListarOrcamentosCliente(){
        $sql_lista = "SELECT V.COD_VENDA,
                            C.DSC_CLIENTE,
                            U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                            DTA_VENDA,
                            CONCAT('Mês: ',MONTH(DTA_VENDA), ' Ano: ',YEAR(DTA_VENDA)) AS MES_ANO,
                            SUM((COALESCE(VP.VLR_VENDA,0)-(COALESCE(VP.VLR_DESCONTO,0)))*VP.QTD_VENDIDA) AS VLR_VENDA,
                            V.NRO_PLACA,
                            VC.COD_VEICULO,
                            V.COD_USUARIO,
                            V.COD_CLIENTE,
                            V.DSC_VEICULO,
                            COALESCE(V.TXT_OBSERVACAO,'') AS TXT_OBSERVACAO,
                            C.NRO_TELEFONE_CONTATO,
                            C.NRO_TELEFONE_CELULAR,
                            C.NRO_CPF,
                            C.TXT_LOGRADOURO,
                            C.NRO_CNPJ
                       FROM EN_VENDA V
                       LEFT JOIN EN_CLIENTE C
                         ON V.COD_CLIENTE = C.COD_CLIENTE
                       LEFT JOIN EN_VEICULOS VC
                         ON V.COD_VEICULO = VC.COD_VEICULO
                       LEFT JOIN RE_VENDA_PRODUTO VP
                         ON V.COD_VENDA = VP.COD_VENDA
                       LEFT JOIN SE_USUARIO U
                         ON V.COD_USUARIO = U.COD_USUARIO
                      WHERE V.COD_CLIENTE = '".filter_input(INPUT_POST, 'codClienteVenda', FILTER_SANITIZE_STRING)."'
                        AND V.NRO_STATUS_VENDA = 'O'
                      GROUP BY V.COD_VENDA,
                               C.DSC_CLIENTE,
                               U.NME_USUARIO_COMPLETO,
                               V.DTA_VENDA";
        return $this->selectDB("$sql_lista", false);
    }

    function VerificaOrcamentosAberto($codUsuario){
        $sql_lista = "SELECT COUNT(*) AS QTD
                            FROM EN_VENDA
                           WHERE COD_USUARIO = $codUsuario
                             AND NRO_STATUS_VENDA = 'O'";
        return $this->selectDB("$sql_lista", false);
    }
    
    Public Function CarregaDadosVenda(){
        $sql_lista = "SELECT V.COD_VENDA,
                            C.DSC_CLIENTE,
                            U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                            DTA_VENDA,
                            CONCAT('Mês: ',MONTH(DTA_VENDA), ' Ano: ',YEAR(DTA_VENDA)) AS MES_ANO,
                            SUM((COALESCE(VP.VLR_VENDA,0)-(COALESCE(VP.VLR_DESCONTO,0)))*VP.QTD_VENDIDA) AS VLR_VENDA,
                            SUM(COALESCE(VP.VLR_DESCONTO,0)*VP.QTD_VENDIDA) AS VLR_DESCONTO,
                            V.NRO_PLACA,
                            VC.COD_VEICULO,                            
                            V.COD_USUARIO,
                            V.COD_CLIENTE,
                            VC.DSC_VEICULO,
                            COALESCE(V.TXT_OBSERVACAO,'') AS TXT_OBSERVACAO,
                            C.NRO_TELEFONE_CONTATO,
                            C.NRO_TELEFONE_CELULAR,
                            C.NRO_CPF,
                            C.TXT_LOGRADOURO,
                            C.NRO_CNPJ,
                            V.NRO_STATUS_VENDA
                       FROM EN_VENDA V
                       LEFT JOIN EN_CLIENTE C
                         ON V.COD_CLIENTE = C.COD_CLIENTE
                       LEFT JOIN EN_VEICULOS VC
                         ON V.COD_VEICULO = VC.COD_VEICULO
                       LEFT JOIN RE_VENDA_PRODUTO VP
                         ON V.COD_VENDA = VP.COD_VENDA
                       LEFT JOIN SE_USUARIO U
                         ON V.COD_USUARIO = U.COD_USUARIO
                      WHERE V.COD_VENDA = '".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_STRING)."'
                      GROUP BY V.COD_VENDA,
                               C.DSC_CLIENTE,
                               U.NME_USUARIO_COMPLETO,
                               V.DTA_VENDA";
        return $this->selectDB("$sql_lista", false);
    }

    

    function ListarOrcamentos($codClienteFinal){
        try{
            $sql_lista = "SELECT COD_VENDA,
                                 DSC_VENDA
                            FROM EN_VENDA
                           WHERE COD_CLIENTE_FINAL = $codClienteFinal";
            $lista = $this->selectDB("$sql_lista", false);
        }catch(Exception $e){
            echo "erro".$e;
        }
        return $lista;
    }

    function InsertVenda($codClienteFinal){
        $txtObservacao = str_replace('"', '', filter_input(INPUT_POST, 'txtObservacao', FILTER_SANITIZE_STRING));
        $txtObservacao = str_replace("'", "", $txtObservacao);
        $codVenda = $this->CatchUltimoCodigo('EN_VENDA', 'COD_VENDA');
        $sql_lista = "
        INSERT INTO EN_VENDA (
            COD_VENDA,
            DTA_VENDA,
            NRO_STATUS_VENDA,
            COD_CLIENTE,
            COD_USUARIO,
            IND_VENDA_LOCADA,
            VLR_DESCONTO,
            DSC_VEICULO,
            NRO_PLACA,
            COD_VEICULO,
            TXT_OBSERVACAO,
            COD_CLIENTE_FINAL)
        VALUES(".$codVenda.",
                '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVenda', FILTER_SANITIZE_STRING))."',
                'O',
                ".filter_input(INPUT_POST, 'codClienteVenda', FILTER_SANITIZE_NUMBER_INT).",
                ".filter_input(INPUT_POST, 'codVendedor', FILTER_SANITIZE_NUMBER_INT).",
                'N',
                0,
                '".filter_input(INPUT_POST, 'dscVeiculoAuto', FILTER_SANITIZE_STRING)."',
                '".filter_input(INPUT_POST, 'nroPlaca', FILTER_SANITIZE_STRING)."',
                ".filter_input(INPUT_POST, 'codVeiculoAuto', FILTER_SANITIZE_NUMBER_INT).",
                '".$txtObservacao."',
                $codClienteFinal)";
        $return = $this->insertDB("$sql_lista");
        $return[2] = $codVenda;
        return $return;
    }

    function UpdateVenda(){
        $txtObservacao = str_replace('"', '', filter_input(INPUT_POST, 'txtObservacao', FILTER_SANITIZE_STRING));
        $txtObservacao = str_replace("'", "", $txtObservacao);
        $sql =
         "UPDATE EN_VENDA SET
            DTA_VENDA = '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVenda', FILTER_SANITIZE_STRING))."',
            COD_CLIENTE = ".filter_input(INPUT_POST, 'codClienteVenda', FILTER_SANITIZE_NUMBER_INT).",
            COD_USUARIO = ".filter_input(INPUT_POST, 'codVendedor', FILTER_SANITIZE_NUMBER_INT).",
            DSC_VEICULO = '".filter_input(INPUT_POST, 'dscVeiculoAuto', FILTER_SANITIZE_STRING)."',
            NRO_PLACA = '".filter_input(INPUT_POST, 'nroPlaca', FILTER_SANITIZE_STRING)."',
            COD_VEICULO = '".filter_input(INPUT_POST, 'codVeiculoAuto', FILTER_SANITIZE_NUMBER_INT)."',
            TXT_OBSERVACAO = '".$txtObservacao."'
          WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT); 
        $return = $this->insertDB("$sql");
        $return[2] = filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        return $return;

    }

    function CancelarVenda(){
        $sql_lista = "
        UPDATE EN_VENDA SET NRO_STATUS_VENDA = 'C'
         WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }
    function ReabrirVenda(){
        $sql_lista = "
        UPDATE EN_VENDA SET NRO_STATUS_VENDA = 'A'
         WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        return $result;

    }

    Public Function TransformaOrcamentoVenda(){
        $sql_lista = "
        UPDATE EN_VENDA SET NRO_STATUS_VENDA = 'A'
         WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
    }
}
?>
