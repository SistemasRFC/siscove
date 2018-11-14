$(function() {
    valor = '{x:'+$(window).width/2+', y:'+$(window).heigth/2+'}';
    $( "#dialogInformacao" ).jqxWindow({
        autoOpen: false,
        height: 150,
        width: 450,
        theme: theme,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        position: {x:400, y:300},
        title: 'Mensagem',
        isModal: true
    });   
    $( "#CadastroForm" ).jqxWindow({
        autoOpen: true,
        height: 150,
        width: 450,
        theme: theme,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        position: {x:400, y:300},
        title: 'Esqueci Minha Senha'
    });         
    $("#nroCpf").mask('999.999.999-99');
    $("#btnResetar").jqxButton({ width: '150', theme: theme });
    $("#btnResetar").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, Resetando Senha!");
        $( "#dialogInformacao" ).jqxWindow("open");        
        $.post('../../Controller/Seguranca/UsuarioController.php',
               {
                   method: 'ResetaSenha',
                   nroCpf: $("#nroCpf").val()
               },
               function(logar){
                    logar = eval ('('+logar+')');
                    if (logar[0]==true){
                        window.location.href='../../index.php';
                    }else{
                        $( "#dialogInformacao" ).jqxWindow('setContent', logar[1]);
                    }
               }
        );
    });

});
$(document).ready(function(){
    $("#nmeLogin").focus();
});