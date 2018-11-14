$(function () {
    $("#indVeiculoAtivo").jqxCheckBox({ width: 120, height: 25, theme: theme });
    $( "#dtaVenda" ).jqxDateTimeInput({width: '250px', height: '25px',culture: 'pt-BR', theme:theme, formatString: "dd/MM/yyyy"});
    var dataAdapter_cliente = '';
    $("#dscClienteAuto").keyup(function(){ 
        if ($(this).val().trim()!=''){
            CriarDivAutoComplete($(this).attr('id'), 
                                 "../../Controller/Cliente/ClienteController.php", 
                                 'ListarClienteAutoComplete',
                                 "codClienteVenda;id|dscClienteAuto;value", 
                                 "value", 
                                 "id",
                                 "CarregaDadosCliente()");            
        }else{
            if ( $("#divAutoComplete").length ){
                $("#divAutoComplete").jqxWindow("destroy");
            }
        }
    });
    $("#dscClienteAuto").focus(function(){
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    });   
    $("#nroPlaca").mask("aaa-9999");
    var dataAdapter_veiculo = '';
    
    $("#dscVeiculoAuto").keyup(function(){   
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
        
    });    
    $("#dscVeiculoAuto").focus(function(){        
        if ($("#divAutoComplete").length){
            $("#divAutoComplete").jqxWindow("destroy");
        }
    }); 
    $("#btnNovo").click(function(){
        $("#dadosCliente").hide('fade');
        $("#nroStatusVenda").val('');
        $("#codVenda").val('');
        $("#codClienteVenda").val('');
        $("#dscClienteAuto").val('');
        $("#dtaVenda").val('');
        $("#codVendedor").val('');
        $("#dscVeiculoAuto").val('');
        $("#codVeiculoAuto").val('');
        $("#nroPlaca").val('');
        $("#txtObservacao").val(''); 
        $("#method").val('InsertVenda'); 
        $(".btnResumoVenda").hide();
        $('#jqxTabsOrcamentos').jqxTabs({ disabled:true });
    });   
    $("#btIncCliente").click(function(){
        $("#NovoClienteForm").jqxWindow("open");
    });
    $( "#btnSalvarCliente" ).click(function( event ) {
        $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
        $( "#dialogInformacao" ).jqxWindow("open");         
        $.post('../../Controller/Cliente/ClienteController.php',
            {method: 'AddCliente',
            codCliente: $("#codCliente").val(),
            dscCliente: $("#dscCliente").val(),
            fone: $("#fone").val(),
            foneCelular: $("#foneCelular").val(),
            nroCpf: $("#nroCpf").val(),
            nroCnpj: $("#nroCnpj").val(),
            txtEndereco: $("#txtEndereco").val()}, function(data){

            data = eval('('+data+')');
            if (data[0]){
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Cliente salvo com sucesso!');
                MontaDadosCliente(data[2], $("#dscCliente").val(), $("#nroCpf").val(), $("#nroCnpj").val(), $("#fone").val(), $("#foneCelular").val(), $("#txtEndereco").val());
                $('#jqxTabsOrcamentos').jqxTabs({ disabled:true });
                $(".btnResumoVenda").hide();
                $("#method").val('InsertVenda');
                $('#codClienteVenda').val(data[2]);
                $('#dscClienteAuto').val($("#dscCliente").val());
                $("#codVeiculoAuto").val('0');
                $("#dscVeiculoAuto").val('');
                $("#nroPlaca").val('');
                $("#txtObservacao").val('');
                window.setTimeout(function() { $( "#dialogInformacao" ).jqxWindow("close"); }, 2000);
                $("#NovoClienteForm").jqxWindow("close");
            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao inserir cliente!');
                window.setTimeout(function() { $( "#dialogInformacao" ).jqxWindow( "close" ); }, 3000);
            }
        });
    }); 
    $( "#btnSalvarVeiculo" ).click(function( event ) {
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
        if ($("#codVeiculoAuto").val()==''){
            $("#codVeiculoAuto").val('0');
        }
        $.post('../../Controller/Orcamentos/OrcamentosController.php',
            {method: $("#method").val(),
            codVenda: $("#codVenda").val(),
            codClienteVenda: $("#codClienteVenda").val(),
            dtaVenda: $("#dtaVenda").val(),
            codVendedor: $("#codVendedor").val(),
            dscVeiculoAuto: $("#dscVeiculoAuto").val(),
            nroPlaca: $("#nroPlaca").val(),
            codVeiculoAuto: $("#codVeiculoAuto").val(),
            txtObservacao: $("#txtObservacao").val(),
            nroStatusVenda: $("#nroStatusVenda").val()}, function(data){

            data = eval('('+data+')');

            if (data[0]>0){
                $("#codVenda").val(data[2]);
                $("#method").val('UpdateVenda');
                $( "#dialogInformacao" ).jqxWindow('setContent', "Registro Salvo!");
                setTimeout($( "#dialogInformacao" ).jqxWindow("close"),2000);
                $('#jqxTabsOrcamentos').jqxTabs({ disabled:false });
                $(".btnResumoVenda").hide();

            }
        });        
    });  
    $("#btIncVeiculo").click(function(){
        $("#NovoVeiculoForm").jqxWindow("open");
    });
    
    
    $("#btnOrcamentosAbertas").click(function(){
        CarregaListaOrcamentosAbertas();
    });
    
    $("#btnGerarVenda").click(function(){
        CarregaCabecalhoOrcamento();
        CarregaProdutosOrcamento();
        $("#GerarVendaForm").jqxWindow("open");
    }); 
});    