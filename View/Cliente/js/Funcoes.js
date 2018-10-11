function CadCliente(method, registro){
     $( "#CadastroForm" ).jqxWindow( "open" );
     $("#method").val(method);
     if (registro==0){
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
        
     }else{
        $("#codCliente").val(registro.COD_CLIENTE);
        $("#dscCliente").val(registro.DSC_CLIENTE);  
        $("#fone").val(registro.NRO_TELEFONE_CONTATO);
        $("#foneCelular").val(registro.NRO_TELEFONE_CELULAR); 
        $("#nroCpf").val(registro.NRO_CPF);
        $("#nroCnpj").val(registro.NRO_CNPJ); 
        $("#nroIe").val(registro.NRO_IE); 
        
        if (registro.IND_TIPO_CLIENTE=='F'){
            $("#comboCodTipoPessoa").val(registro.IND_TIPO_CLIENTE);
            $("#codTipoPessoa").val(registro.IND_TIPO_CLIENTE);
            mostraDivById('nroCpf');
            escondeDivById('nroCnpj');
        }else if (registro.IND_TIPO_CLIENTE=='J'){
            $("#comboCodTipoPessoa").val(registro.IND_TIPO_CLIENTE);
            $("#codTipoPessoa").val(registro.IND_TIPO_CLIENTE);
            mostraDivById('nroCnpj');
            escondeDivById('nroCpf');
        }else{
            $("#comboCodTipoPessoa").val("-1");
            $("#codTipoPessoa").val(registro.IND_TIPO_CLIENTE);
            escondeDivById('nroCnpj');
            escondeDivById('nroCpf');            
        }        
        
        if (registro.DTA_NASCIMENTO!=null){
            datas = registro.DTA_NASCIMENTO.split('/');
            $("#dtaNascimento").val(new Date(datas[2]+', '+datas[1]+' ,'+datas[0]));        
        }else{
            $("#dtaNascimento").val("");        
        }
//        $("#dtaNascimento").val(registro.DTA_NASCIMENTO);  
        $("#txtEmail").val(registro.TXT_EMAIL);
        $("#nroCep").val(registro.NRO_CEP);
        $("#txtLogradouro").val(registro.TXT_LOGRADOURO);
        $("#txtComplemento").val(registro.TXT_COMPLEMENTO);
        $("#nmeBairro").val(registro.NME_BAIRRO);
        $("#nmeCidade").val(registro.TXT_LOCALIDADE);
        $("#sglUf").val(registro.SGL_UF);
        $("#txtUnidade").val(registro.TXT_UNIDADE);
        $("#codIbge").val(registro.COD_IBGE);
        $("#codGia").val(registro.COD_GIA);        
    }
}

function CarregaGridCliente(){
    var pesquisa = $("#parametro").val();
    pesquisa = pesquisa.trim();
    if (pesquisa.length<3){
//        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite pelo menos 3 letras!");
//        $( "#dialogInformacao" ).jqxWindow("open");      
        return;
    }                      
    $("#tdGrid").html('');
    $("#tdGrid").html('<div id="ListagemForm"></div>');
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open");
    $.post('../../Controller/Cliente/ClienteController.php',
        {method: 'ListarClienteGrid',
         parametro: $("#parametro").val()},function(data){

            data = eval('('+data+')');
            if (data[0]){
                MontaTabelaCliente(data[1]);         
                $( "#dialogInformacao" ).jqxWindow("close");      

            }else{
                $( "#dialogInformacao" ).jqxWindow('setContent', "Erro: "+data[1]);             
            }
    });
}

function MontaTabelaCliente(listaClientes){
    var nomeGrid = 'ListagemForm';
    var source =
    {
        localdata: listaClientes,
        datatype: "json",
        datafields:
        [
            { name: 'COD_CLIENTE', type: 'int' },
            { name: 'DSC_CLIENTE', type: 'string' },
            { name: 'NRO_CPF', type: 'string' },
            { name: 'NRO_CNPJ', type: 'string' },
            { name: 'NRO_IE', type: 'string' },
            { name: 'NRO_TELEFONE_CONTATO', type: 'string' },
            { name: 'NRO_TELEFONE_CELULAR', type: 'string' },
            { name: 'DTA_NASCIMENTO', type: 'string' },
            { name: 'TXT_EMAIL', type: 'string' },
            { name: 'IND_TIPO_CLIENTE', type: 'string' },
            { name: 'NRO_CEP', type: 'string' },
            { name: 'TXT_LOGRADOURO', type: 'string' },
            { name: 'TXT_COMPLEMENTO', type: 'string' },
            { name: 'NME_BAIRRO', type: 'string' },
            { name: 'TXT_LOCALIDADE', type: 'string' },
            { name: 'SGL_UF', type: 'string' },
            { name: 'COD_IBGE', type: 'string' },
            { name: 'COD_GIA', type: 'string' },
            { name: 'IND_TIPO_CLIENTE', type: 'string' },
            { name: 'TXT_UNIDADE', type: 'string' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#"+nomeGrid).jqxGrid(
    {
        width: 500,
        source: dataAdapter,
        theme: theme,
        sortable: true,
        filterable: true,
        pageable: false,
        columnsresize: true,
        selectionmode: 'singlerow',
        scrollmode: 'logical',
        columns: [
            { text: 'CPF', datafield: 'NRO_CPF', columntype: 'textbox', width: 150},
            { text: 'Nome', datafield: 'DSC_CLIENTE', columntype: 'textbox', width: 280}
          
        ]
    });
    $("#"+nomeGrid).jqxGrid('localizestrings', localizationobj);
    $('#'+nomeGrid).on('rowdoubleclick', function (event)
    {
        var args = event.args;
        CadCliente('UpdateCliente',$('#'+nomeGrid).jqxGrid('getrowdatabyid', args.rowindex));
    });
    $("#dialogInformacao" ).jqxWindow("close");  
}

function MontaComboTipoPessoa(nmeCombo, nmeSelect, seleciona){
    $("#"+nmeCombo).jqxDropDownList({ width: '157px', height: '25px'});
    $("#"+nmeCombo).jqxDropDownList('loadFromSelect', nmeSelect);  
    $("#"+nmeSelect).val(seleciona);
    var index = $("#"+nmeSelect)[0].selectedIndex;
    $("#"+nmeCombo).jqxDropDownList('selectIndex', index);
    $("#"+nmeCombo).jqxDropDownList('ensureVisible', index);    
    
    $("#"+nmeCombo).on('select', function (event) {
        var args = event.args;
        // select the item in the 'select' tag.
        var index = args.item.index;
        $("#"+nmeSelect).val(args.item.value);
        if ($("#"+nmeSelect).val()=='F'){
            $(".trCPF").html("CPF");
            mostraDivById('nroCpf');
            escondeDivById('nroCnpj');
        }else if ($("#"+nmeSelect).val()=='J'){
            $(".trCPF").html("CNPJ");
            mostraDivById('nroCnpj');
            escondeDivById('nroCpf');
        }else{
            $(".trCPF").html("");
            escondeDivById('nroCnpj');
            escondeDivById('nroCpf');            
        }
        
    });  
    $("#"+nmeSelect).on('change', function (event) {
        updating = true;
        $("#"+nmeSelect).val(seleciona);

        var index = $("#"+nmeSelect)[0].selectedIndex;
        $("#"+nmeCombo).jqxDropDownList('selectIndex', index);
        $("#"+nmeCombo).jqxDropDownList('ensureVisible', index);
        updating = false;
    });    
}

function mostraDivById(nmeDiv){
    $("#"+nmeDiv).show();
}

function escondeDivById(nmeDiv){
    $("#"+nmeDiv).hide();
}

function mostraDivByClass(nmeDiv){
    $("."+nmeDiv).show();
}

function escondeDivByClass(nmeDiv){
    $("."+nmeDiv).hide();
}

function fechaDialog(){
    $( "#dialogInformacao" ).jqxWindow("close"); 
}

function SalvarCliente(){
    $( "#dialogInformacao" ).jqxWindow('setContent', "Aguarde!");
    $( "#dialogInformacao" ).jqxWindow("open"); 
    if ($("#dscCliente").val().trim()==''){
        $( "#dialogInformacao" ).jqxWindow('setContent', "Digite o Nome do Cliente!");
        $("#dscCliente").focus();
        return false;
    }
    var cep = $("#nroCep").val();
    cep = cep.replace('.','');
    cep = cep.replace('-','');
    $.post('../../Controller/Cliente/ClienteController.php',
        {method: $("#method").val(),
        codCliente: $("#codCliente").val(),
        dscCliente: $("#dscCliente").val(),
        dtaNascimento: $("#dtaNascimento").val(),
        txtEmail: $("#txtEmail").val(),
        fone: $("#fone").val(),
        foneCelular: $("#foneCelular").val(),
        codTipoPessoa: $("#codTipoPessoa").val(),
        nroCpf: $("#nroCpf").val(),
        nroCnpj: $("#nroCnpj").val(),
        nroIe: $("#nroIe").val(),
        nroCep: cep,
        txtLogradouro: $("#txtLogradouro").val(),
        txtComplemento: $("#txtComplemento").val(),
        nmeBairro: $("#nmeBairro").val(),
        nmeCidade: $("#nmeCidade").val(),
        sglUf: $("#sglUf").val(),
        codIbge: $("#codIbge").val(),
        codGia: $("#codGia").val(),
        txtUnidade: $("#txtUnidade").val()
    }, function(data){

        data = eval('('+data+')');
        if (data[0]){
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Cliente salvo com sucesso!');
            window.setTimeout(function (){
                $( "#dialogInformacao" ).jqxWindow('close');
                $( "#CadastroForm" ).jqxWindow('close');
                CarregaGridCliente();
            }, '2000');  
        }else{
            $( "#dialogInformacao" ).jqxWindow('setContent', 'Erro ao salvar cliente! '+data[1]);
        }
    });    
}