<?php
include_once("../../Dao/BaseDao.php");
class FuncionarioDao extends BaseDao
{
    Public Function FuncionarioDao(){
        $this->conect();
    }

    Public Function ListarFuncionarioGrid($codClienteFinal){
        $sql_lista = "SELECT COD_USUARIO AS COD_FUNCIONARIO,
                          NME_USUARIO_COMPLETO AS NME_FUNCIONARIO,
                          U.COD_DEPOSITO,
                          D.DSC_DEPOSITO,
                          NME_USUARIO,
                          TXT_EMAIL,
                          NRO_TEL_CELULAR,
                          VLR_PORCENTAGEM_SERVICO,
                          VLR_PORCENTAGEM_VENDA,
                          VLR_PORCENTAGEM_GERENCIA,
                          U.COD_PERFIL_W,
                          U.DTA_INATIVO,
                          U.IND_ATIVO
                     FROM SE_USUARIO U
                    INNER JOIN EN_DEPOSITO D
                       ON U.COD_DEPOSITO = D.COD_DEPOSITO
                    WHERE COD_CLIENTE_FINAL = $codClienteFinal
                      AND U.COD_PERFIL_W NOT IN (1)";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function ListarFuncionariosAtivos($codClienteFinal){
        $sql_lista = "SELECT COD_USUARIO AS COD_FUNCIONARIO,
                             NME_USUARIO_COMPLETO AS NME_FUNCIONARIO
                        FROM SE_USUARIO U
                       INNER JOIN EN_DEPOSITO D
                          ON U.COD_DEPOSITO = D.COD_DEPOSITO
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal
                         AND U.COD_PERFIL_W NOT IN (1)
                         AND U.IND_ATIVO = 'S'
                       ORDER BY NME_USUARIO_COMPLETO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function ListarVendedoresAtivos($codClienteFinal){
        $sql_lista = "SELECT COD_USUARIO AS COD_FUNCIONARIO,
                             NME_USUARIO_COMPLETO AS NME_FUNCIONARIO
                        FROM SE_USUARIO U
                       INNER JOIN EN_DEPOSITO D
                          ON U.COD_DEPOSITO = D.COD_DEPOSITO
                       WHERE COD_CLIENTE_FINAL = $codClienteFinal
                         AND U.COD_PERFIL_W = 4
                         AND U.IND_ATIVO = 'S'
                       ORDER BY NME_USUARIO_COMPLETO";
        return $this->selectDB("$sql_lista", false);
    }

    Public Function AddFuncionario($codClienteFinal){
        $login = $this->RetornaLogin(filter_input(INPUT_POST, 'nmeFuncionario', FILTER_SANITIZE_STRING));
        if ($login[0]){
            $nmeLogin = $login[2];
        }else{
            $nmeLogin = '';
        }
        $senha = base64_encode("123459");
        $codFuncionario = $this->CatchUltimoCodigo('SE_USUARIO', 'COD_USUARIO');
        $sql_lista = "INSERT INTO SE_USUARIO (COD_USUARIO, NME_USUARIO, NME_USUARIO_COMPLETO, TXT_SENHA_W, COD_DEPOSITO, NRO_TEL_CELULAR, TXT_EMAIL, VLR_PORCENTAGEM_SERVICO, VLR_PORCENTAGEM_VENDA, VLR_PORCENTAGEM_GERENCIA, COD_PERFIL_W, IND_ATIVO)
                     VALUES(".$codFuncionario.",
                            '".$nmeLogin."',
                            '".filter_input(INPUT_POST, 'nmeFuncionario', FILTER_SANITIZE_STRING)."',
                            '".$senha."',
                            ".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_NUMBER_INT).",
                            '".filter_input(INPUT_POST, 'nroTelefone', FILTER_SANITIZE_STRING)."',
                            '".filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_STRING)."',
                            '".filter_input(INPUT_POST, 'vlrPorcentagemServico', FILTER_SANITIZE_STRING)."',
                            '".filter_input(INPUT_POST, 'vlrPorcentagemVenda', FILTER_SANITIZE_STRING)."',
                            '".filter_input(INPUT_POST, 'vlrPorcentagemGerencia', FILTER_SANITIZE_STRING)."',
                            ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT).",
                            '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."')";
        $result = $this->insertDB("$sql_lista");
        $result[2] = $codFuncionario;
        $result[3] = $nmeLogin;
        return $result;
    }

    Public Function UpdateFuncionario(){
        $sql_lista =
         "UPDATE SE_USUARIO
             SET NME_USUARIO_COMPLETO='".filter_input(INPUT_POST, 'nmeFuncionario', FILTER_SANITIZE_STRING)."',
                 COD_DEPOSITO = ".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_NUMBER_INT).",
                 TXT_EMAIL = '".filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_STRING)."',
                 NRO_TEL_CELULAR = '".filter_input(INPUT_POST, 'nroTelefone', FILTER_SANITIZE_STRING)."',
                 VLR_PORCENTAGEM_SERVICO = '".filter_input(INPUT_POST, 'vlrPorcentagemServico', FILTER_SANITIZE_STRING)."',
                 VLR_PORCENTAGEM_VENDA = '".filter_input(INPUT_POST, 'vlrPorcentagemVenda', FILTER_SANITIZE_STRING)."',
                 VLR_PORCENTAGEM_GERENCIA = '".filter_input(INPUT_POST, 'vlrPorcentagemGerencia', FILTER_SANITIZE_STRING)."',
                 COD_PERFIL_W = ".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT).",
                 IND_ATIVO = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."'    
           WHERE COD_USUARIO = ".filter_input(INPUT_POST, 'codFuncionario', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        return $result;
    }

    Public Function RetornaLogin($nmeUsuario){
        $nome = explode(" ", $nmeUsuario);
        $primeiro_nome = $nome[0];
        $ultimo_nome = end($nome);
        $nome = $primeiro_nome.'.'.$ultimo_nome;
        $i=1;
        $login=true;
        while ($login){
            $sql = "SELECT COUNT(*) AS QTD FROM SE_USUARIO WHERE NME_USUARIO = '".$nome."'";
            $result = $this->selectDB($sql, false);       
            if ($result[0]){
                if ($result[1][0]['QTD']>0){
                    $nome = $nome.$i;
                }else{
                    $login = false;
                }
            }else{
                $login = false;
            }            
            $i++;
        }        
        $result[2] = $nome; 
        return $result;
    }
}
?>
