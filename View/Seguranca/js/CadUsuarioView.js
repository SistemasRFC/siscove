$(function() {
    $("#nroCpf").mask('999.999.999-99');
    
    $("#btnReiniciarSenha").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, salvando registro!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
        $( "#dialogInformacao" ).jqxWindow("open");        
        $('#method').val('ReiniciarSenha');
        $.post('../../Controller/Seguranca/UsuarioController.php',
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
    $("#btnSalvar").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, salvando registro!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
        $( "#dialogInformacao" ).jqxWindow("open");
        var cpf = $("#nroCpf").val();
        cpf = $.trim(cpf);
        if (cpf.length<=0){
            $( "#dialogInformacao" ).jqxWindow('setContent', "<h4 style='text-align:center;'>Digite o CPF!<br></h4>");
            exit;
        }
        if ($('#codUsuario').val()==0){
            $('#method').val('AddUsuario');
        }else{
            $('#method').val('UpdateUsuario');
        }
        if ($("#indUsuarioAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }           
        var checkBoxes = '';
        $(".check").each(function(){
            if ($(this).jqxCheckBox('val')){
                checkBoxes += $(this).attr('id')+';S|';
            }else{
                checkBoxes += $(this).attr('id')+';N|';
            }          
        });        
        $.post('../../Controller/Seguranca/UsuarioController.php',
              {method: $("#method").val(),
               nmeUsuario: $("#nmeUsuario").val(),
               codUsuario: $("#codUsuario").val(),
               nmeLogin: $("#nmeLogin").val(),
               codPerfil: $("#codPerfil").val(),
               codProjeto: $("#codProjeto").val(),
               nroCpf: $("#nroCpf").val(),
               checkBoxes: checkBoxes,
               indAtivo: ativo,
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
});
function CarregaListaProjetos(codUsuario){
    if (codUsuario>0){
        method = 'ListarProjetosUsuariosAtivos';
    }else{
        method = 'ListarProjetosAtivos'
    }
    $.post('../../Controller/Projeto/ProjetoController.php',
        {method: method,
        codUsuario: codUsuario}, function(data){

        data = eval('('+data+')');
        if (data[0]){            
            MontaListaProjetos(data[1]);
        }
    });
}
function MontaComboPerfil(){    
    var source =
    {
        datatype: "json",
        type: "POST",
        datafields: [
            { name: 'COD_MENU_W', type: 'string'},
            { name: 'DSC_MENU_W', type: 'string'}
        ],
        cache: false,
        url: '../../Controller/Seguranca/PerfilController.php',
        data:{
              method: 'ListarPerfilRestrito'
        }
    };        
    var dataAdapter = new $.jqx.dataAdapter(source,{
        loadComplete: function (records){         
            $("#codPerfil").jqxDropDownList(
            {
                source: records[1],
                theme: 'energyblue',
                width: 200,
                height: 25,
                selectedIndex: 0,
                displayMember: 'DSC_PERFIL_W',
                valueMember: 'COD_PERFIL_W'
            });  
        },
        async:true
                     
    });  
    dataAdapter.dataBind();
}
function MontaListaProjetos(ListaProjetos){
    count=1;
    tabela = '';      
    for(i=0;i<ListaProjetos.length;i++){
        if (count==1){
            tabela += "<tr>";
            count=0;
        }       
        dscMenu = ListaProjetos[i].NME_PROJETO;
        tabela += "<td width='400px'>";
        tabela += "<div id='"+ListaProjetos[i].COD_PROJETO+"' style='margin-left: 10px; float: left;' class='check'><span>"+dscMenu+"</span></div><br>";
        tabela += "</td>";
        count++;
        if (count==1){
            tabela += "</tr>";
        }
    }    
    $("#ListaProjetos").html(tabela);
    var theme = 'energyblue';
    $(".check").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $('.check').jqxCheckBox('uncheck');
    for(i=0;i<ListaProjetos.length;i++){        
        if (ListaProjetos[i].PROJETO==null){            
            $("#"+ListaProjetos[i].COD_PROJETO).jqxCheckBox('uncheck');
        }else{            
            $("#"+ListaProjetos[i].COD_PROJETO).jqxCheckBox('check');
        }
    } 
}
$(document).ready(function(){
    var theme = 'energyblue';
    $("#indUsuarioAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $("input[type='button']").button();    
    MontaComboPerfil();

});