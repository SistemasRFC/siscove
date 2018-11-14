<html>
    <head>
        <title>Sistema de vendas online</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8; IBM850; ISO-8859-1">
    <script language="JavaScript" type="text/JavaScript"></script>
    <script src="../../Resources/JavaScript.js"></script>
    <link href="../../Resources/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet">
    <script src="../../Resources/js/jquery-1.9.0.js"></script>
    <script src="../../Resources/js/jquery-ui-1.10.0.custom.js"></script>
        <script>
            $(function() {
                $( "#dialogInformacao" ).dialog({
                        autoOpen: false,
                        width: 450,
                        show: 'explode',
                        hide: 'explode',
                        title: 'Mensagem',
                        modal: true,
                        buttons: [
                                {
                                        text: "Ok",
                                        click: function() {
                                                $( this ).dialog( "close" );
                                        }
                                }
                        ]
                });
                $( "#CadastroForm" ).dialog({
                    autoOpen: false,
                    width: 400,
                    title: 'Alteração de Senha',
                    buttons: [
                        {
                            text: "Alterar",
                            click: function() {
                                if ($("#txtSenha").val()==$("#txtSenhaAnterior").val()){
                                    if ($("#txtNova").val()==$("#txtConfirmacao").val()){
                                        $('#method').val('AlteraSenha');
                                        $('#pagina').val('../../View/MenuPrincipal.php');
                                        $('#paginaError').val('index.php');
                                        document.AlteraSenhaForm.submit();
                                    }else{
                                        $( "#dialogInformacao" ).html('Confirme a senha nova!');
                                        $( "#dialogInformacao" ).dialog( "open" );
                                    }
                                }else{
                                    $( "#dialogInformacao" ).html('Digite a senha atual corretamente!');
                                    $( "#dialogInformacao" ).dialog( "open" );
                                }
                                
                            }
                        }
                    ]
                });

                // Link to open the dialog
                $( "#dialog-link" ).click(function( event ) {
                    $(this).show("explode", { pieces: 16 }, 2000);
                    $( "#CadastroForm" ).dialog( "open" );
                    event.preventDefault();
                });

            });

        </script>
        <script type="text/javascript">
            function carregaModal(){
                $( "#CadastroForm" ).dialog( "open" );
            }
        </script>
    </head>
    <body onLoad="javascript:carregaModal();">
        <div id="CadastroForm">
            <form name="AlteraSenhaForm" id="AlteraSenhaForm" method="post" action="../../Controller/Login/LoginController.php">
                <input type="hidden" id="method" name="method">
                <input type="hidden" id="txtSenhaAnterior" name="txtSenhaAnterior"
                       value="<?
                                if (isset($_REQUEST['txtSenha'])){
                                    echo base64_decode($_REQUEST['txtSenha']);
                                }
                                ?>">
                <input type="hidden" id="pagina" name="pagina">
                <input type="hidden" id="paginaError" name="paginaError">
                <table>
                    <tr>
                        <td>
                            Senha Atual
                        </td>
                        <td><input type="password" id="txtSenha" name="txtSenha"></td>
                    </tr>
                    <tr>
                        <td>
                            Nova Senha
                        </td>
                        <td><input type="password" id="txtNova" name="txtNova"></td>
                    </tr>
                    <tr>
                        <td>
                            Senha
                        </td>
                        <td><input type="password" id="txtConfirmacao" name="txtConfirmacao"></td>
                    </tr>
                </table>
                <div id="dialogInformacao">
                </div>
            </form>
        </div>
    </body>
</html>