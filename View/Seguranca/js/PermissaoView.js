$(function() {
    $( "#dialogInformacao" ).jqxWindow({
        autoOpen: false,
        height: 150,
        width: 450,
        theme: theme,
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        title: 'Mensagem',
        isModal: true
    });
    $("#btnSalvar").jqxButton({ width: '100', theme: theme });
    $("#btnSalvar").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, salvando permiss&otilde;es!");
        $( "#dialogInformacao" ).jqxWindow("open");
        $('#method').val('AtualizaPermissoes');
        var checkBoxes = '';
        $.post('../../Controller/Seguranca/PermissaoController.php',
            {method: 'ListarMenus',
            codPerfil: $("#codPerfil").val()}, function(dados){

            dados = eval('('+dados+')');            
            data = dados[1];
            if (data!=null){
                for (i=0;i<data.length;i++){                    
                    if ($("#chk"+data[i].COD_MENU_W).jqxCheckBox('val')){
                        checkBoxes += data[i].COD_MENU_W+';S|';
                    }else{
                        checkBoxes += data[i].COD_MENU_W+';N|';
                    }
                }
                $.post('../../Controller/Seguranca/PermissaoController.php',
                    {method: $('#method').val(),
                    codPerfil: $("#codPerfil").val(),
                    C: checkBoxes}, function(data){

                    data = eval('('+data+')');
                    if (data[0]){
                        $( "#dialogInformacao" ).jqxWindow("close");
                    }
                });
            }
        });        
    });
    $("#codPerfil").change(function(){
        CarregaListaMenus();
    });
});
function CarregaListaMenus(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde, atualizando");
    $( "#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Seguranca/PermissaoController.php',
        {method: 'ListarMenus',
        codPerfil: $("#codPerfil").val()}, function(data){

        data = eval('('+data+')');
        ListaMenus(data[1]);
    });
}
function ListaMenus(ListaMenus){
    count=3;
    tabela = '';
    for(i=0;i<ListaMenus.length;i++){
        if (count==3){
            tabela += "<tr>";
            count=0;
        }       
        if (ListaMenus[i].DSC_MENU_PAI!=null){
            dscMenu = "<strong>"+ListaMenus[i].DSC_MENU_PAI+"</strong>>>>"+ListaMenus[i].DSC_MENU_W;
        }else{
            dscMenu = ListaMenus[i].DSC_MENU_W;
        }
        tabela += "<td width='400px'>";
        tabela += "<div id='chk"+ListaMenus[i].COD_MENU_W+"' style='margin-left: 10px; float: left;' class='check'><span>"+dscMenu+"</span></div><br>";
        tabela += "</td>";
        count++;
        if (count==3){
            tabela += "</tr>";
        }
    }
    $("#checkboxes").html(tabela);
    var theme = theme;
    // Create jqxCheckBox
    $(".check").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $('.check').jqxCheckBox('uncheck');
    for(i=0;i<ListaMenus.length;i++){        
        if (ListaMenus[i].PERFIL==null){            
            $("#chk"+ListaMenus[i].COD_MENU_W).jqxCheckBox('uncheck');
        }else{            
            $("#chk"+ListaMenus[i].COD_MENU_W).jqxCheckBox('check');
        }
    } 
    $( "#dialogInformacao" ).jqxWindow("close");
}

function CarregaComboPerfil(){
    $("#dialogInformacao").jqxWindow('setContent', "<h4 style='text-align:center;'>Aguarde, carregando Combo!<br><img src='../../Resources/images/carregando.gif' width='200' height='30'></h4>");
    $("#dialogInformacao" ).jqxWindow("open");    
    $.post('../../Controller/Seguranca/PerfilController.php',
           {
               method: 'ListarPerfilAtivo'
           },
           function(listaPefil){
                listaPefil = eval ('('+listaPefil+')');
                if (listaPefil[0]==true){
                    MontaComboPerfil(listaPefil[1]);
                    CarregaListaMenus(listaPefil[1][0].COD_PERFIL_W);
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
$(document).ready(function () {
    $('#checkboxes').html("<img src='../../Resources/images/carregando.gif' width='200' height='30'>");
    //CarregaListaMenus();
    CarregaComboPerfil();
});