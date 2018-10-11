<html>
    <script language='Javascript'>
    segundos = 11;
    function contagem_tempo(){               
        document.getElementById('cont').innerHTML = segundos;
        document.getElementById('seconds').value = segundos; 
        segundos = segundos - 1;
        if (segundos == -1) {
            segundos = 0;
            window.location.href='http://siscove.webhop.net/siscove';
        }   
        timerID = setTimeout("contagem_tempo()",1000);   
    }     
    </script>    
    <body onLoad="javascript:contagem_tempo();">
        <input type="hidden" id="seconds">
        <div id="cabecalho">
            <table width="100%" align="left">
                <tr>
                        <td align="left"
                    style="text-align:left;
                           height:10%;
                           font-size:14px;
                           color:#0150D3;
                           vertical-align:middle;
                           font-family: arial, helvetica, serif;">
                            A partir de hoje o novo endereço para utilização do sistema é <a href="http://siscove.webhop.net/siscove">http://siscove.webhop.net/siscove</a>
                            </br>
                            Caso a Página não te redirecione para o novo endereço em <label id="cont"></label> segundos, clique no link acima.
                        </td>
                </tr>

            </table>
        </div>
    </body>
</html>