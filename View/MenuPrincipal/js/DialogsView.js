var widthTela = screen.width;
var heightTela = screen.height;
$(function() { 
    $( "#dialogInformacao" ).jqxWindow({
        autoOpen: false,
        height: 150,
        width: 450,
        theme: 'energyblue',
        position: {x: (widthTela/2)-(450/2), y: (heightTela/2)-(150/2)},
        animationType: 'fade',
        showAnimationDuration: 500,
        closeAnimationDuration: 500,
        title: 'Mensagem',
        isModal: true
    });       
});