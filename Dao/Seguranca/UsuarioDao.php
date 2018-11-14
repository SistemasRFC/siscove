<?php
include_once("../../Dao/BaseDao.php");
class UsuarioDao extends BaseDao
{
    function UsuarioDao(){
        $this->conect();
    }

    function ListarUsuario($codPerfil, $codCliente){
        $sql = "SELECT DISTINCT U.COD_USUARIO,
                          NME_USUARIO_COMPLETO,
                          NME_USUARIO,
                          U.TXT_EMAIL,
                          U.COD_PERFIL_W,
                          P.DSC_PERFIL_W,
                          u.IND_ATIVO
                     FROM SE_USUARIO U 
                     INNER JOIN SE_PERFIL P 
                        ON U.COD_PERFIL_W = P.COD_PERFIL_W                 
                     WHERE U.COD_PERFIL_W  IN (SELECT COD_PERFIL_ACESSO
                                           FROM RE_PERMISSAO_PERFIL
                                          WHERE COD_PERFIL = $codPerfil)";
        return $this->selectDB("$sql", false);
    }
    
    function AddUsuario(){        
        $codUsuario = $this->CatchUltimoCodigo('SE_USUARIO', 'COD_USUARIO');
        $nroCpf = str_replace('-','',str_replace('.', '', filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_STRING)));
        $senha = base64_encode("123459");
        $sql_lista = "INSERT INTO SE_USUARIO (
                             COD_USUARIO,
                             NME_USUARIO,
                             NME_USUARIO_COMPLETO,
                             COD_DEPOSITO,
                             TXT_SENHA_W,
                             TXT_EMAIL,
                             COD_PERFIL_W,
                             IND_ATIVO)
                     VALUES(".$codUsuario.",
                            '".filter_input(INPUT_POST, 'nmeLogin', FILTER_SANITIZE_MAGIC_QUOTES)."',
                            '".filter_input(INPUT_POST, 'nmeUsuario', FILTER_SANITIZE_MAGIC_QUOTES)."',
                            ".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_NUMBER_INT).",
                            '".$senha."',
                            '".filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_MAGIC_QUOTES)."',
                            '".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT)."',
                            '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."')";
                             
        $result = $this->insertDB("$sql_lista");
        if ($result[0]){
            $result[1]= $codUsuario;
        }
        return $result;
    }
    
    function UpdateUsuario(){     
        $nroCpf = str_replace('-','',str_replace('.', '', filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_NUMBER_INT)));
        $sql_lista =  "UPDATE SE_USUARIO
                          SET NME_USUARIO          = '".filter_input(INPUT_POST, 'nmeLogin', FILTER_SANITIZE_MAGIC_QUOTES)."',
                              NME_USUARIO_COMPLETO = '".filter_input(INPUT_POST, 'nmeUsuario', FILTER_SANITIZE_MAGIC_QUOTES)."',
                              TXT_EMAIL            = '".filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_MAGIC_QUOTES)."',
                              COD_PERFIL_W         = '".filter_input(INPUT_POST, 'codPerfil', FILTER_SANITIZE_NUMBER_INT)."',
                              COD_DEPOSITO         = '".filter_input(INPUT_POST, 'codDeposito', FILTER_SANITIZE_STRING)."',
                              IND_ATIVO            = '".filter_input(INPUT_POST, 'indAtivo', FILTER_SANITIZE_STRING)."'
           WHERE COD_USUARIO = ".filter_input(INPUT_POST, 'codUsuario', FILTER_SANITIZE_NUMBER_INT);        
        $result = $this->insertDB("$sql_lista");        
        if ($result[0]){
            $result[1]=  filter_input(INPUT_POST, 'codUsuario', FILTER_SANITIZE_NUMBER_INT);
        }
        return $result;

    }

    function DeleteUsuario(){        
        $sql_lista = "
        DELETE FROM SE_USUARIO
         WHERE COD_USUARIO = ".filter_input(INPUT_POST, 'codUsuario', FILTER_SANITIZE_NUMBER_INT);
        $result = $this->insertDB("$sql_lista");
        return $result;
    }

    function ReiniciarSenha(){        
        $senha = base64_encode("123459");
        $sql_lista =  "UPDATE SE_USUARIO
                          SET TXT_SENHA_W          = '".$senha."'
           WHERE COD_USUARIO = ".filter_input(INPUT_POST, 'codUsuario', FILTER_SANITIZE_NUMBER_INT);
        if ($this->insertDB("$sql_lista")){
            return filter_input(INPUT_POST, 'codUsuario', FILTER_SANITIZE_NUMBER_INT);
        }else{
            return 0;
        }

    }

    Public Function ResetaSenha(){
        $nroCpf = str_replace('-','',str_replace('.', '', filter_input(INPUT_POST, 'nroCpf', FILTER_SANITIZE_NUMBER_INT)));
        $sql = "SELECT COD_USUARIO FROM SE_USUARIO WHERE NRO_CPF = '".$nroCpf."'";
        $rs = $this->selectDB($sql, false);
        if ($rs[0]){
            if ($rs[1][0]['COD_USUARIO']>0){
                $senha = base64_encode("123459");
                $sql_lista =  "UPDATE SE_USUARIO
                                  SET TXT_SENHA_W = '".$senha."'
                   WHERE COD_USUARIO = ".$rs[1][0]['COD_USUARIO'];
                $rs = $this->insertDB("$sql_lista");
            }else{
                $rs[0]=false;
                $rs[1]='CPF n&atilde;o encontrado na base de dados!';
            }
        }
        return $rs;
    }  
}
?>
