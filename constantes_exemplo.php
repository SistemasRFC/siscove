<?php
/**
 * Arquivo de Constantes do Sistema para ser configurado
 * Ap�s a configura��o este arquivo deve ser renomeado
 */
const PORT     = "";
const USER     = "";
const PASSWORD = "";
const CONEXAO  = "";
const DB       = "";

define ('AMBIENTE', 'HMG');
if (AMBIENTE=='HMG'){
    define ('TOKEN', '');
    define ('URL', '');
}else{
    define ('TOKEN', '');
    define ('URL', '');
}
