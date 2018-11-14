$(function() {
    $("#CadastroForm").jqxWindow({ 
        title: 'Cadastro de Funcionários',
        height: 500,
        width: 500,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });  
    $( "#btnNovo" ).click(function( event ) {
        CadFuncionario('AddFuncionario', 0);        
    });
});
$(document).ready(function(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $(document).on('contextmenu', function (e) {
        return false;
    });
    CarregaGridFuncionario();    
    CriarCombo('codDeposito', 
               '../../Controller/Deposito/DepositoController.php', 
               'method;ListarDepositosAtivos', 
               'COD_DEPOSITO|DSC_DEPOSITO', 
               'DSC_DEPOSITO', 
               'COD_DEPOSITO');     
    //MontaComboDeposito();
    CriarCombo('codPerfil', 
               '../../Controller/Perfil/PerfilController.php', 
               'method;ListarPerfilRestrito', 
               'COD_PERFIL_W|DSC_PERFIL_W', 
               'DSC_PERFIL_W', 
               'COD_PERFIL_W');     
    //MontaComboPerfil();
    $("#dialogInformacao" ).jqxWindow("close");
});