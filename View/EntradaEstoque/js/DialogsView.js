$(document).ready(function () {
    $("#ListaChequesRecebidosForm").jqxWindow({ 
        title: 'Lista de cheques recebidos',
        height: 450,
        width: 1000,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    }); 
    $("#EntradasAbertasForm").jqxWindow({ 
        title: 'Lista de entradas no estoque em aberto',
        height: 450,
        width: 1000,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });      
    $("#EntradasFechadasForm").jqxWindow({ 
        title: 'Lista de entradas no estoque',
        height: 450,
        width: 1000,
        maxWidth: 1200,
        position: { x: 200, y: 100 },
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        theme: theme,
        isModal: true,
        autoOpen: false
    });      
//    $("#dialogJustificativa").jqxWindow({ 
//        title: 'Justificativa',
//        height: 250,
//        width: 500,
//        maxWidth: 1200,
//        animationType: 'fade',
//        position: { x: 200, y: 100 },
//        showAnimationDuration: 500,
//        closeAnimationDuration: 500,
//        theme: theme,
//        isModal: true,
//        autoOpen: false
//    });       
//    $("#NovoClienteForm").jqxWindow({ 
//        title: 'Cadastrar novo cliente',
//        height: 450,
//        width: 800,
//        maxWidth: 1200,
//        position: { x: 200, y: 100 },
//        animationType: 'fade',
//        showAnimationDuration: 500,
//        closeAnimationDuration: 500,
//        theme: theme,
//        isModal: true,
//        autoOpen: false
//    });       
//    $("#dialogRelatorioResumoVenda").jqxWindow({ 
//        title: 'Resumo da venda',
//        height: 450,
//        width: 800,
//        maxWidth: 1200,
//        position: { x: 200, y: 100 },
//        animationType: 'fade',
//        showAnimationDuration: 500,
//        closeAnimationDuration: 500,
//        theme: theme,
//        isModal: true,
//        autoOpen: false
//    });         
//    $("#NovoVeiculoForm").jqxWindow({ 
//        title: 'Cadastrar novo veiculo',
//        height: 450,
//        width: 800,
//        maxWidth: 1200,
//        position: { x: 200, y: 100 },
//        animationType: 'fade',
//        showAnimationDuration: 500,
//        closeAnimationDuration: 500,
//        theme: theme,
//        isModal: true,
//        autoOpen: false
//    });        
//    $("#AvisoVendasAbertas").jqxWindow({ 
//        title: 'Aviso',
//        height: 250,
//        width: 400,
//        maxWidth: 1200,
//        position: { x: 300, y: 200 },
//        animationType: 'fade',
//        showAnimationDuration: 500,
//        closeAnimationDuration: 500,
//        theme: theme,
//        isModal: true,
//        autoOpen: false
//    }); 
});