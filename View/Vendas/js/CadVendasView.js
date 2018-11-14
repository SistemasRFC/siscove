$(function () {
    $("#dtaVenda").jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
       
    $("#dscClienteAuto").keyup(function(key){ 
        if ((key.keyCode!=40) && (key.keyCode!=38)){
            if ($(this).val().trim()!=''){
                CriarDivAutoComplete($(this).attr('id'), 
                                     "../../Controller/Cliente/ClienteController.php", 
                                     'ListarClienteAutoComplete',
                                     "codClienteVenda;id|dscClienteAuto;value|nroCpfPesquisaAuto;NRO_CPF", 
                                     "value", 
                                     "id", 
                                     "CarregaDadosCliente()");            
            }else{
                if ( $("#divAutoComplete").length ){
                    $("#divAutoComplete").jqxWindow("destroy");
                }
            }
        }else{            
            $("#listaPesquisa").jqxListBox('selectedIndex' ,0);
            $("#listaPesquisa").jqxListBox("focus");
        }
    });
    
    $("#dscClienteAuto").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });  

    $("#nroCpfPesquisaAuto").keyup(function(key){ 
        if ((key.keyCode!=40) && (key.keyCode!=38)){
            if ($(this).val().length>=6){
                CriarDivAutoComplete($(this).attr('id'), 
                                     "../../Controller/Cliente/ClienteController.php", 
                                     'ListarClienteCpfAutoComplete',
                                     "codClienteVenda;id|dscClienteAuto;value|nroCpfPesquisaAuto;NRO_CPF", 
                                     "value", 
                                     "id", 
                                     "CarregaDadosCliente()",
                                     300);            
                                     
            }else{
                if ( $("#divAutoComplete").length ){
                    $("#divAutoComplete").jqxWindow("destroy");
                }
            }
        }else{            
            $("#listaPesquisa").jqxListBox('selectedIndex' ,0);
            $("#listaPesquisa").jqxListBox("focus");
        }
    });
    
    $("#nroCpfPesquisaAuto").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    }); 
    
    $("#nroPlaca").mask("aaa-9999");
    
    $("#dscVeiculoAuto").keyup(function(key){   
        if ((key.keyCode!=40) && (key.keyCode!=38)){
            if ($(this).val().trim()!=''){
                CriarDivAutoComplete($(this).attr('id'), 
                                     "../../Controller/Veiculo/VeiculoController.php", 
                                     'ListarVeiculosAutoComplete',
                                     "codVeiculoAuto;id|dscVeiculoAuto;value", 
                                     "value", 
                                     "id",
                                     null);            
            }else{
                if ( $("#divAutoComplete").length ){
                    $("#divAutoComplete").jqxWindow("destroy");
                }
            }
        }else{
            $("#listaPesquisa").jqxListBox('selectedIndex' ,0);
            $("#listaPesquisa").jqxListBox("focus");
        }
    }); 
    
    $("#dscVeiculoAuto").focus(function(){        
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });  
    
    $("#btnCancelaVenda").click(function(){
        if ($("#dscClienteAuto").val()==0){
            $( "#dialogInformacao" ).jqxWindow('setContent','Selecione uma venda antes!');
            $( "#dialogInformacao" ).jqxWindow( "open" );
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent','Cancelando Venda');
            $( "#dialogInformacao" ).jqxWindow( "open" );
            $.post('../../Controller/Vendas/VendasController.php',{
                method:'CancelarVenda',
                codVenda: $("#codVenda").val()}, function(data){

                data = eval('('+data+')');
                $("#resultado").html('');
                if (data[0]){
                    $("#nroStatusVenda").val('');
                    $("#codVenda").val('');
                    $("#codClienteVenda").val('');
                    $("#dscClienteAuto").val('');
                    $("#nroCpfPesquisaAuto").val('');
                    $("#dtaVenda").val('');
                    $("#codVendedor").val('');
                    $("#dscVeiculoAuto").val('');
                    $("#codVeiculoAuto").val('');
                    $("#nroPlaca").val('');
                    $("#txtObservacao").val('');
                    $("#vlrKmRodado").val('');
                    $('#jqxTabsVendas').jqxTabs({disabled:true});
                    $('#dadosCliente').hide();
                    $(".codigo").text('');
                    $(".status").text('');
                    $( "#dialogInformacao" ).jqxWindow('setContent','Venda Cancelada com sucesso!');
                    window.setTimeout(function() { $( "#dialogInformacao" ).jqxWindow( "close" ); }, 4000);
                }else{
                    $( "#dialogInformacao" ).jqxWindow('setContent','Erro ao cancelar venda! <br>'+data[1]);
                }
            });
        }        
    });
    
    $("#btnNovo").click(function(){
        $("#nroStatusVenda").val('');
        $("#codVenda").val('');
        $("#codClienteVenda").val('');
        $("#dscClienteAuto").val('');
        $("#nroCpfPesquisaAuto").val('');
        $("#dtaVenda").val('');
        $("#codVendedor").val('');
        $("#dscVeiculoAuto").val('');
        $("#codVeiculoAuto").val('');
        $("#nroPlaca").val('');
        $("#txtObservacao").val(''); 
        $('#jqxTabsVendas').jqxTabs('select', 0);
        $("#vlrKmRodado").val('');
        $("#method").val('InsertVenda'); 
        $('#dadosCliente').hide();
        $("#btnNota").hide();
        $("#btnCancelarNota").hide();
        $("#btnReabrirVenda").hide();
        $("#btnEnviarEmail").hide();
        $(".codigo").text('');
        $(".status").text('');
        $(".TabelaMae").removeClass("disabledTable");
        $('#jqxTabsVendas').jqxTabs({ disabled:true });
    });  
    
    $("#btIncCliente").click(function(){
        $("#codCliente").val("0");
        $("#dscCliente").val(""); 
        $("#fone").val("");
        $("#foneCelular").val("");
        $("#nroCpf").val("");
        $("#nroCnpj").val(""); 
        $("#nroIe").val(""); 
        $("#dtaNascimento").val(""); 
        $("#txtEmail").val("");         
//        $("#comboCodTipoPessoa").val("");
        $("#comboCodTipoPessoa").jqxDropDownList('selectIndex', -1 ); 
        $("#nroCep").val("");
        $("#txtLogradouro").val("");
        $("#txtComplemento").val("");
        $("#nmeBairro").val("");
        $("#nmeCidade").val("");
        $("#sglUf").val("");
        $("#txtUnidade").val("");
        $("#codIbge").val("");
        $("#codGia").val("");
        $("#NovoClienteForm").jqxWindow("open");
    });
         
    $("#btnSalvarVeiculo").click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");  
        if ($("#indVeiculoAtivo").jqxCheckBox('val')){
            ativo = 'S';
        }else{
            ativo = 'N';
        }            
        $.post('../../Controller/Veiculo/VeiculoController.php',
            {method: 'AddVeiculo',
            codVeiculo: $("#codVeiculo").val(),
            dscVeiculo: $("#dscVeiculo").val(),
            indVeiculoAtivo: ativo}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                $("#dscVeiculoAuto").val($("#dscVeiculo").val());
                $("#codVeiculoAuto").val($("#codVeiculo").val());
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Registro salvo com sucesso!');
                window.setTimeout(function() { $( "#dialogInformacao" ).jqxWindow( "close" ); }, 3000);
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar Registro!');
            }
        });
    }); 
    
    $("#btnSalvarVenda").click(function(){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");  
        if ($("#codVendedor").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Selecione um vendedor!");
            return false;
        }
        if ($("#dtaVenda").val().trim()==''){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Selecione uma data da venda!");
            return false;            
        }
        if ($("#vlrKmRodado").val().trim()=='' && $("#nroStatusVenda").val()=='A'){
            $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o KM do veículo, caso não haja, coloque 0!");
            return false;                        
        }
        $.post('../../Controller/Vendas/VendasController.php',
            {method: $("#method").val(),
            codVenda: $("#codVenda").val(),
            codClienteVenda: $("#codClienteVenda").val(),
            dtaVenda: $("#dtaVenda").val(),
            codVendedor: $("#codVendedor").val(),
            dscVeiculoAuto: $("#dscVeiculoAuto").val(),
            nroPlaca: $("#nroPlaca").val(),
            vlrImpostoProduto: $("#vlrImpostoProduto").val(),
            vlrImpostoServico: $("#vlrImpostoServico").val(),
            codVeiculoAuto: $("#codVeiculoAuto").val(),
            txtObservacao: $("#txtObservacao").val(),
            vlrKmRodado: $("#vlrKmRodado").val(),
            nroStatusVenda: $("#nroStatusVenda").val()}, function(data){

            data = eval('('+data+')');

            if (data[0]>0){
                $("#codVenda").val(data[2]);
                CarregaDadosVenda();
                $("#method").val('UpdateVenda');
                $( "#dialogInformacao" ).jqxWindow('setContent', "Registro Salvo!");
                setTimeout($( "#dialogInformacao" ).jqxWindow("close"),2000);
                $('#jqxTabsVendas').jqxTabs({ disabled:false });

            }
        });        
    });  
    
    $("#btIncVeiculo").click(function(){
        $("#CadVeiculos").jqxWindow("open");
    });
        
    $("#btnVendasAbertas").click(function(){
        CarregaListaVendasAbertas();
    });
    $("#btnHistoricoVenda").click(function(){
        CarregaHistoricoVenda($("#codVenda").val());
    }); 
});