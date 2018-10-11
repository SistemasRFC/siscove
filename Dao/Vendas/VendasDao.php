<?php
include_once("../../Dao/BaseDao.php");
class VendasDao extends BaseDao
{
    Public Function VendasDao(){
        $this->conect();
    }

    Public Function ListarVendasAberto($codClienteFinal){
        $sql = "SELECT V.COD_VENDA,
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
                            V.VLR_IMPOSTO_PRODUTO,
                            V.VLR_IMPOSTO_SERVICO,
                            V.VLR_KM_RODADO,
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
                      WHERE V.NRO_STATUS_VENDA = '".filter_input(INPUT_POST, 'nroStatusVenda', FILTER_SANITIZE_STRING)."'
                        AND V.COD_CLIENTE_FINAL = $codClienteFinal ";
             if (filter_input(INPUT_POST, 'indAno', FILTER_SANITIZE_STRING)=='S'){
                 $sql .= "  AND YEAR(V.DTA_VENDA) >= YEAR(NOW())-1";
             }
             $sql .= "  GROUP BY V.COD_VENDA,
                               C.DSC_CLIENTE,
                               U.NME_USUARIO_COMPLETO,
                               V.DTA_VENDA
                      ORDER BY V.DTA_VENDA DESC";                  
        return $this->selectDB("$sql", false);
    }
    
    Public Function ListarVendasCliente($tpoVenda){
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
                            V.VLR_IMPOSTO_PRODUTO,
                            V.VLR_IMPOSTO_SERVICO,
                            V.VLR_KM_RODADO,
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
                        ".$tpoVenda."
                      GROUP BY V.COD_VENDA,
                               C.DSC_CLIENTE,
                               U.NME_USUARIO_COMPLETO,
                               V.DTA_VENDA";
        return $this->selectDB("$sql_lista", false);
    }

    function VerificaVendasAberto($codUsuario){
        $sql_lista = "SELECT COUNT(*) AS QTD
                            FROM EN_VENDA
                           WHERE COD_USUARIO = $codUsuario
                             AND NRO_STATUS_VENDA = 'A'";
        return $this->selectDB("$sql_lista", false);
    }
     
    Public Function CarregaDadosVenda(){
        $sql_lista = "SELECT COD_VENDA,
                             DSC_CLIENTE,
                             NME_VENDEDOR,
                             DTA_VENDA,
                             DTA_EMISSAO_NOTA,
                             MES_ANO,
                             SUM(VLR_VENDA) AS VLR_VENDA,
                             SUM(VLR_DESCONTO) AS VLR_DESCONTO,
                             NRO_PLACA,
                             COD_VEICULO,
                             COD_USUARIO,
                             COD_CLIENTE,
                             DSC_VEICULO,
                             VLR_IMPOSTO_PRODUTO,
                             VLR_IMPOSTO_SERVICO,
                             VLR_KM_RODADO,
                             TXT_OBSERVACAO,
                             NRO_TELEFONE_CONTATO,
                             NRO_TELEFONE_CELULAR,
                             NRO_CPF,
                             NRO_CNPJ,
                             NRO_IE,
                             IND_TIPO_CLIENTE,
                             NRO_CEP,
                             TXT_LOGRADOURO,
                             TXT_COMPLEMENTO,
                             NME_BAIRRO,
                             TXT_LOCALIDADE,
                             SGL_UF,
                             TXT_UNIDADE,
                             COD_IBGE,
                             COD_GIA,
                             DSC_STATUS_VENDA,
                             NRO_STATUS_VENDA,
                             IND_STATUS_REFERENCIA
                        FROM (
                      SELECT V.COD_VENDA,
                             C.DSC_CLIENTE,
                             U.NME_USUARIO_COMPLETO AS NME_VENDEDOR,
                             DTA_VENDA,
                             DTA_EMISSAO_NOTA,
                             CONCAT('Mês: ',MONTH(DTA_VENDA), ' Ano: ',YEAR(DTA_VENDA)) AS MES_ANO,
                             (COALESCE(VP.VLR_VENDA,0)-(COALESCE(VP.VLR_DESCONTO,0)))*VP.QTD_VENDIDA AS VLR_VENDA,
                             COALESCE(VP.VLR_DESCONTO,0)*VP.QTD_VENDIDA AS VLR_DESCONTO,
                             V.NRO_PLACA,
                             VC.COD_VEICULO,                            
                             V.COD_USUARIO,
                             V.COD_CLIENTE,
                             VC.DSC_VEICULO,
                             V.VLR_IMPOSTO_PRODUTO,
                             V.VLR_IMPOSTO_SERVICO,
                             V.VLR_KM_RODADO,
                             COALESCE(V.TXT_OBSERVACAO,'') AS TXT_OBSERVACAO,
                             C.NRO_TELEFONE_CONTATO,
                             C.NRO_TELEFONE_CELULAR,
                             C.NRO_CPF,
                             C.IND_TIPO_CLIENTE,
                             C.NRO_CEP,
                             C.TXT_LOGRADOURO,
                             C.TXT_COMPLEMENTO,
                             C.NME_BAIRRO,
                             C.TXT_LOCALIDADE,
                             C.SGL_UF,
                             C.TXT_UNIDADE,
                             C.COD_IBGE,
                             C.COD_GIA,
                             C.NRO_CNPJ,
                             C.NRO_IE,
                             CASE WHEN V.NRO_STATUS_VENDA='A' THEN 'Aberto'
                                  WHEN V.NRO_STATUS_VENDA='C' THEN 'Cancelado'
                                  WHEN V.NRO_STATUS_VENDA='F' THEN 'Fechado'
                             END AS DSC_STATUS_VENDA,
                             V.NRO_STATUS_VENDA,
                             VR.IND_STATUS_REFERENCIA
                        FROM EN_VENDA V
                        LEFT JOIN EN_CLIENTE C
                          ON V.COD_CLIENTE = C.COD_CLIENTE
                        LEFT JOIN EN_VEICULOS VC
                          ON V.COD_VEICULO = VC.COD_VEICULO
                        LEFT JOIN RE_VENDA_PRODUTO VP
                          ON V.COD_VENDA = VP.COD_VENDA
                        LEFT JOIN SE_USUARIO U
                          ON V.COD_USUARIO = U.COD_USUARIO
                        LEFT JOIN EN_VENDA_REFERENCIA VR
                          ON V.COD_VENDA = VR.COD_VENDA
                         AND VR.NRO_SEQUENCIAL = (SELECT MAX(NRO_SEQUENCIAL) FROM EN_VENDA_REFERENCIA WHERE COD_VENDA = ".$this->Populate('codVenda', 'I').")
                       WHERE V.COD_VENDA = '".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_STRING)."'
                       GROUP BY V.COD_VENDA,
                                VP.COD_PRODUTO,
                                C.DSC_CLIENTE,
                                U.NME_USUARIO_COMPLETO,
                                V.DTA_VENDA) AS X";
//        echo $sql_lista; die;
        return $this->selectDB("$sql_lista", false);
    }

    function ListarVendas($codClienteFinal){
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
        $vlrImpostoProduto = str_replace('.', '', filter_input(INPUT_POST, 'vlrImpostoProduto', FILTER_SANITIZE_STRING));
        $vlrImpostoProduto = str_replace(',', '.', $vlrImpostoProduto);        
        $vlrImpostoServico = str_replace('.', '', filter_input(INPUT_POST, 'vlrImpostoServico', FILTER_SANITIZE_STRING));
        $vlrImpostoServico = str_replace(',', '.', $vlrImpostoServico);  
        $codVeiculo = filter_input(INPUT_POST, 'codVeiculoAuto', FILTER_SANITIZE_NUMBER_INT);
        if ($codVeiculo==''){
            $codVeiculo=0;
        }
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
            COD_CLIENTE_FINAL,
            VLR_IMPOSTO_PRODUTO,
            VLR_IMPOSTO_SERVICO,
            VLR_KM_RODADO)
        VALUES(".$codVenda.",
                '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVenda', FILTER_SANITIZE_STRING))."',
                'A',
                ".filter_input(INPUT_POST, 'codClienteVenda', FILTER_SANITIZE_NUMBER_INT).",
                ".filter_input(INPUT_POST, 'codVendedor', FILTER_SANITIZE_NUMBER_INT).",
                'N',
                0,
                '".filter_input(INPUT_POST, 'dscVeiculoAuto', FILTER_SANITIZE_STRING)."',
                '".filter_input(INPUT_POST, 'nroPlaca', FILTER_SANITIZE_STRING)."',
                ".$codVeiculo.",
                '".$txtObservacao."',
                $codClienteFinal,
                '".$vlrImpostoProduto."',
                '".$vlrImpostoServico."',
                '".filter_input(INPUT_POST, 'vlrKmRodado', FILTER_SANITIZE_NUMBER_INT)."')";
//        /echo $sql_lista; die;
        $return = $this->insertDB("$sql_lista");
        $return[2] = $codVenda;
        return $return;
    }

    function UpdateVenda(){
        $txtObservacao = str_replace('"', '', filter_input(INPUT_POST, 'txtObservacao', FILTER_SANITIZE_STRING));
        $txtObservacao = str_replace("'", "", $txtObservacao);
        $vlrImpostoProduto = str_replace('.', '', filter_input(INPUT_POST, 'vlrImpostoProduto', FILTER_SANITIZE_STRING));
        $vlrImpostoProduto = str_replace(',', '.', $vlrImpostoProduto);        
        $vlrImpostoServico = str_replace('.', '', filter_input(INPUT_POST, 'vlrImpostoServico', FILTER_SANITIZE_STRING));
        $vlrImpostoServico = str_replace(',', '.', $vlrImpostoServico); 
        $sql_lista =
         "UPDATE EN_VENDA SET
            DTA_VENDA = '".$this->ConverteDataForm(filter_input(INPUT_POST, 'dtaVenda', FILTER_SANITIZE_STRING))."',
            COD_CLIENTE = ".filter_input(INPUT_POST, 'codClienteVenda', FILTER_SANITIZE_NUMBER_INT).",
            COD_USUARIO = ".filter_input(INPUT_POST, 'codVendedor', FILTER_SANITIZE_NUMBER_INT).",
            DSC_VEICULO = '".filter_input(INPUT_POST, 'dscVeiculoAuto', FILTER_SANITIZE_STRING)."',
            NRO_PLACA = '".filter_input(INPUT_POST, 'nroPlaca', FILTER_SANITIZE_STRING)."',
            COD_VEICULO = '".filter_input(INPUT_POST, 'codVeiculoAuto', FILTER_SANITIZE_STRING)."',
            VLR_IMPOSTO_PRODUTO = '".$vlrImpostoProduto."',
            VLR_IMPOSTO_SERVICO = '".$vlrImpostoServico."',
            TXT_OBSERVACAO = '".$txtObservacao."',
            VLR_KM_RODADO = ".filter_input(INPUT_POST, 'vlrKmRodado', FILTER_SANITIZE_NUMBER_INT)."
          WHERE COD_VENDA = ".filter_input(INPUT_POST, 'codVenda', FILTER_SANITIZE_NUMBER_INT);         
        $return = $this->insertDB("$sql_lista");
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
    
    Public function RegistroVendaInsert($codUsuario, $tpoOperacao, $codVenda){
        $sql = "INSERT INTO EN_LOG_VENDA (COD_VENDA, COD_USUARIO, DTA_OPERACAO, TPO_OPERACAO)
                VALUES ($codVenda,
                        $codUsuario,
                        NOW(),
                        '$tpoOperacao')";
        return $this->insertDB($sql);
    }
}
?>
