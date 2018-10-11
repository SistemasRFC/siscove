<?php
include_once("../../Dao/BaseDao.php");
class AlunoDao extends BaseDao
{
    Protected $tableName = "EN_ALUNO";
    
    Protected $columns = array ("nmeAluno"   => array("column" =>"NME_ALUNO", "typeColumn" =>"S"),
                                "nroCpf"   => array("column" =>"NRO_CPF", "typeColumn" =>"S"),
                                "nroRg"   => array("column" =>"NRO_RG", "typeColumn" =>"S"),
                                "txtEmail"   => array("column" =>"TXT_EMAIL", "typeColumn" =>"S"),
                                "dtaNascimento"   => array("column" =>"DTA_NASCIMENTO", "typeColumn" =>"D"),
                                "nroTelefoneComercial"   => array("column" =>"NRO_TELEFONE_COMERCIAL", "typeColumn" =>"S"),
                                "nroTelefoneCelular"   => array("column" =>"NRO_TELEFONE_CELULAR", "typeColumn" =>"S"),
                                "codProfissao"   => array("column" =>"COD_PROFISSAO", "typeColumn" =>"I"),
                                "dtaCadastro"   => array("column" =>"DTA_CADASTRO", "typeColumn" =>"D"),
                                "codGenero"   => array("column" =>"COD_GENERO", "typeColumn" =>"I"),
                                "txtEndereco"   => array("column" =>"TXT_ENDERECO", "typeColumn" =>"S"),
                                "nmeBairro"   => array("column" =>"NME_BAIRRO", "typeColumn" =>"S"),
                                "indAtivo"   => array("column" =>"IND_ATIVO", "typeColumn" =>"S"),
                                "codLoja"   => array("column" =>"COD_LOJA", "typeColumn" =>"I"));
    
    Protected $columnKey = array("codAluno"=> array("column" =>"COD_ALUNO", "typeColumn" => "I"));
    
    Public Function AlunoDao(){
        $this->conect();
    }

    Public Function ListarAluno(){    
        return $this->MontarSelect();
    }

    Public Function UpdateAluno(){
        return $this->MontarUpdate();
    }

    Public Function InsertAluno($codLoja){
        return $this->MontarInsert($codLoja);
    }
}