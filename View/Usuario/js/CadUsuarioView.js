$(function() {
    $("#nroCpf").mask('999.999.999-99'); 
    $("#indAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });    
    $("#btnReiniciarSenha").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, salvando registro!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
        $( "#dialogInformacao" ).jqxWindow("open");        
        $('#method').val('ReiniciarSenha');
        $.post('../../Controller/Usuario/UsuarioController.php',
              {method: $("#method").val(),
               codUsuario: $("#codUsuario").val()}, function(data){
            data = eval('('+data+')');
            if (data[0]){          
                $( "#dialogInformacao" ).jqxWindow('setContent',"<h4 style='text-align:center;'>Usu&aacute;rio salvo com sucesso!\n\r A Senha para Acessar &eacute; 123459.</h4>");
                setTimeout(function(){
                    $("#CadUsuarios").jqxWindow("close");
                    $( "#dialogInformacao" ).jqxWindow("close");                    
                },"2000");                     
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao salvar Usu&aacute;rio!'+data);
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });   
    $("#nroCpf").blur(function(){
       if ((!valCpf($("#nroCpf").val()))&&($("#nroCpf").val()!='')){
            $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>CPF Inv&aacute;lido!</h4>");
            $( "#dialogInformacao" ).jqxWindow("open");    
            $("#nroCpf").focus();
        }
    });  
    $("#btnSalvar").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, salvando registro!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
        $( "#dialogInformacao" ).jqxWindow("open");
        if ($('#codUsuario').val()==0){
            $('#method').val('AddUsuario');
        }else{
            $('#method').val('UpdateUsuario');
        }
        if ($("#indAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }         
        $.post('../../Controller/Usuario/UsuarioController.php',
              {method: $("#method").val(),
               nmeUsuario: $("#nmeUsuario").val(),
               codUsuario: $("#codUsuario").val(),
               nmeLogin: $("#nmeLogin").val(),
               codPerfil: $("#codPerfil").val(),
               codProjeto: $("#codProjeto").val(),
               nroCpf: $("#nroCpf").val(),
               indAtivo: ativo,
               codLoja: $("#codLoja").val(),
               txtEmail: $("#txtEmail").val()}, function(data){

            data = eval('('+data+')');  
            if (data[0]){
                CarregaGridUsuario();
                if (data[1]!=$("#codUsuario").val()){
                    $( "#dialogInformacao" ).jqxWindow('setContent',"<h4 style='text-align:center;'>Usu&aacute;rio salvo com sucesso!\n\r A Senha para Acessar &eacute; 123459.</h4>");
                }else{                   
                    $( "#dialogInformacao" ).jqxWindow('setContent',"<h4 style='text-align:center;'>Usu&aacute;rio salvo com sucesso!</h4>");
                    setTimeout(function(){
                        $( "#dialogInformacao" ).jqxWindow("close");
                        $( "#CadUsuarios" ).jqxWindow("close");
                    },"2000");                     
                }
                $( "#dialogInformacao" ).jqxWindow( "open" );
                $("#codUsuario").val(data[1]);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao salvar Usu&aacute;rio!'+data);
                $( "#dialogInformacao" ).jqxWindow( "open" );
            }
        });
    });
    $("#codCliente").change(function(){
        CarregaLojas($(this).val(),-1);
    });
});
function CarregaComboPerfil(){
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, carregando Combo!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Perfil/PerfilController.php',
           {
               method: 'ListarPerfilRestrito'
           },
           function(listaPefil){
                listaPefil = eval ('('+listaPefil+')');
                if (listaPefil[0]==true){
                    MontaComboPerfil(listaPefil[1]);
                    $( "#dialogInformacao" ).jqxWindow('close');
                }else{                    
                    $( "#dialogInformacao" ).jqxWindow('setContent', 'N&atilde;o foi poss&iacute;vel executar a consulta!<br>'+listaAssunto[1]);
                    $( "#dialogInformacao" ).jqxWindow('open');
                }                
           }
    );
}
function MontaComboPerfil(listaPefil){    
    var source =
    {
        localdata: listaPefil,
        datatype: "json",
        datafields:
        [
            { name: 'COD_PERFIL_W', type: 'string' },
            { name: 'DSC_PERFIL_W', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);    
    $("#codPerfil").jqxDropDownList(
    {
        source: dataAdapter,
        theme: theme,
        width: 200,
        height: 25,
        selectedIndex: 0,
        displayMember: 'DSC_PERFIL_W',
        valueMember: 'COD_PERFIL_W'
    });                
}

function CarregaLojas(codCliente, codLoja){
    $.post('../../Controller/Loja/LojaController.php',
           {
               method: 'ListarLojaAtiva',
               codCliente: codCliente
           },
           function(listaLoja){
                listaLoja = eval ('('+listaLoja+')');
                if (listaLoja[0]){
                    MontaComboLojas(listaLoja[1], codLoja);
                }else{
                    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Erro ao listar Imobili&aacute;rias! <br> "+listaUsuario[1]+"</h4>");                    
                }
           }
    );
}
function MontaComboLojas(listaLoja, codLoja){
    var source =
    {
        localdata: listaLoja,
        datatype: "json",
        datafields:
        [
            { name: 'COD_LOJA', type: 'string' },
            { name: 'DSC_LOJA', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);    
    $("#codLoja").jqxDropDownList(
    {
        source: dataAdapter,
        theme: theme,
        width: 200,
        height: 25,
        selectedIndex: 0,
        displayMember: 'DSC_LOJA',
        valueMember: 'COD_LOJA'
    });  
    $("#codLoja").val(codLoja);
}
//
//function valCpf(c){ 
//    var Soma; 
//    var Resto; 
//    Soma = 0; 
//    var strCPF;
//    strCPF = c.replace(".","");
//    strCPF = strCPF.replace(".","");
//    cpf = strCPF.replace("-","");
//    var numeros, digitos, soma, i, resultado, digitos_iguais;
//    digitos_iguais = 1;
//    if (cpf.length < 11){
//        return false;
//    }
//    for (i = 0; i < cpf.length - 1; i++){
//        if (cpf.charAt(i) != cpf.charAt(i + 1)){
//            digitos_iguais = 0;
//            break;
//        }
//    }
//    if (!digitos_iguais){
//        numeros = cpf.substring(0,9);
//        digitos = cpf.substring(9);
//        soma = 0;
//        for (i = 10; i > 1; i--)
//              soma += numeros.charAt(10 - i) * i;
//        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
//        if (resultado != digitos.charAt(0))
//              return false;
//        numeros = cpf.substring(0,10);
//        soma = 0;
//        for (i = 11; i > 1; i--)
//              soma += numeros.charAt(11 - i) * i;
//        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
//        if (resultado != digitos.charAt(1))
//              return false;
//        return true;
//    }else{
//        return false;
//    }
//}

function CarregaCliente(){
    $.post('../../Controller/Usuario/UsuarioController.php',
           {
               method: 'ListaDadosUsuario'
           },
           function(ListaDadosUsuario){
                ListaDadosUsuario = eval ('('+ListaDadosUsuario+')');
                if (ListaDadosUsuario[0]){
                    MontaComboDadosUsuario(ListaDadosUsuario[1]);
                }else{
                    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Erro ao listar Imobili&aacute;rias! <br> "+ListaDadosUsuario[1]+"</h4>");                    
                }
           }
    );
}

function MontaComboDadosUsuario(ListaDadosUsuario){
    var source =
    {
        localdata: ListaDadosUsuario,
        datatype: "json",
        datafields:
        [
            { name: 'COD_CLIENTE', type: 'string' },
            { name: 'NME_CLIENTE', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);    
    $("#codCliente").jqxDropDownList(
    {
        source: dataAdapter,
        theme: theme,
        width: 200,
        height: 25,
        selectedIndex: -1,
        displayMember: 'NME_CLIENTE',
        valueMember: 'COD_CLIENTE'
    }); 
    if (ListaDadosUsuario[0].COD_PERFIL==1){
        $(".tdDadosCliente").show();
    }else{
        $(".tdDadosCliente").hide();
        $("#codCliente").val(1);
    }    
}
$(document).ready(function(){
    CarregaCliente();
});