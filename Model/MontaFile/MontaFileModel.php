<?php

//include_once("../../Model/BaseModel.php");
include_once("../../Dao/MontaFile/MontaFileDao.php");

class MontaFileModel {

    public function MontaFileModel() {
        if (!isset($_SESSION)) {
            ob_start();
            session_start();
        }
    }

    function ListarTabelas($Json = true) {
        $dao = new MontaFileDao();
        $lista = $dao->ListarTabelas();
        
        if ($Json) {
            return json_encode($lista[1]);
        } else {
            return $lista;
        }
    }

    function GeraController($nmeFile) {
        $ContentController = file_get_contents('../../Controller/MontaFile/Controller.tpl');
        if (!$ContentController) {
            echo 'Não foi possíel ler a Controller.';
        } else {
            $ContentController = str_replace("#class", $nmeFile, $ContentController);
        }
        $dir = "../../Controller/".$nmeFile."/";
        if (!is_dir($dir) && strlen($dir)>0){
            mkdir($dir, 0777);
        }
        $Controller = fopen($dir . $nmeFile . "Controller.php", "w");
        if (!$Controller) {
            echo 'Não foi possíel criar a Controller.  ';
        } else {
            //ftruncate($file, 0);
            fwrite($Controller, $ContentController);
            fclose($Controller);
        }
    }

    function GeralModel($nmeFile) {
        $ModelContent = file_get_contents('../../Controller/MontaFile/Model.tpl');
        if (!$ModelContent) {
            echo 'Não foi possíel ler a Model. ';
        } else {
            $ModelContent = str_replace("#class", $nmeFile, $ModelContent);
        }
        $dir = "../../Model/".$nmeFile."/";
        if (!is_dir($dir) && strlen($dir)>0){
            mkdir($dir, 0777);
        }
        $Model = fopen($dir . $nmeFile . "Model.php", "w");
        if (!$Model) {
            echo 'Não foi possíel criar a Model. ';
        } else {
            fwrite($Model, $ModelContent);
            fclose($Model);
        }
    }

    function GeraDao($nmeFile, $dscTabela) {
        $dao = new MontaFileDao();
        $colunas = $dao->ListarColunas();
        if ($colunas) {
            $Campos = 'array (';
            for ($i = 0; $i < count($colunas[1]); $i++) {
                $stringLower = strtolower($colunas[1][$i][0]);
                $words = str_replace(" ", "", ucwords(str_replace("_", " ", $stringLower)));
                $str = strtolower(substr($words,0,1)).substr($words,1,strlen($words));
                $tpDado = $this->DefineTipoDado($colunas[1][$i][1]);
                if ($colunas[1][$i][3] == 'PRI') {
                    $pk = 'array("' . $str . '"=> array("column" =>"' . $colunas[1][$i][0] . '", "typeColumn" => "I"))';
                } else {
                    $Campos .= '"'.$str . '"   => array("column" =>"' . $colunas[1][$i][0] . '", "typeColumn" =>"' . $tpDado . '"),
                                ';
                }
            }
            $Campos = rtrim($Campos);
            $Campos = substr($Campos, 0, strlen($Campos)-1);
            $Campos .=')';
        } else {
            return $colunas;
        }
        $DaoContent = file_get_contents('../../Controller/MontaFile/Dao.tpl');
        if (!$DaoContent) {
            echo 'Não foi possíel ler a Dao. ';
        } else {
            $DaoContent = str_replace("#class", $nmeFile, $DaoContent);
            $DaoContent = str_replace("#columns", $Campos, $DaoContent);
            $DaoContent = str_replace("#pk", $pk, $DaoContent);
            $DaoContent = str_replace("#dscTabela", strtoupper($dscTabela), $DaoContent);
        }
        $dir = "../../Dao/".$nmeFile."/";
        if (!is_dir($dir) && strlen($dir)>0){
            mkdir($dir, 0777);
        }
        $DaoFile = fopen($dir . $nmeFile . "Dao.php", "w");
        if (!$DaoFile) {
            echo 'Não foi possível criar a Dao. ';
        } else {
            fwrite($DaoFile, $DaoContent);
            fclose($DaoFile);
        }
    }

    function GeraFile() {
        //var_dump($colunas[1]);die;
        $dscTabela = filter_input(INPUT_POST, 'dscTabela', FILTER_SANITIZE_STRING);
        $nmeFile = filter_input(INPUT_POST, 'nmeFile', FILTER_SANITIZE_STRING);

        $this->GeraController($nmeFile);

        $this->GeralModel($nmeFile);

        $this->GeraDao($nmeFile, $dscTabela);
    }

    function DefineTipoDado($tpDado) {
        switch ($tpDado) {
            case substr_count($tpDado, 'int') >= 1:
                $tpDado = "I";
                break;

            case substr_count($tpDado, 'date') >= 1:
                $tpDado = "D";
                break;

            case substr_count($tpDado, 'float') >= 1:
            case substr_count($tpDado, 'double') >= 1:
            case substr_count($tpDado, 'decimal') >= 1:
                $tpDado = "F";
                break;

            case substr_count($tpDado, 'char') >= 1:
            case substr_count($tpDado, 'text') >= 1:
                $tpDado = "S";
                break;

            default :
                break;
        }
        return $tpDado;
    }

}
