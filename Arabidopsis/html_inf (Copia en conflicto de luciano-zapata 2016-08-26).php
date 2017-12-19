</td></tr></table>
</div>
<br><br>
<div align="center" class="pie">
    <img src="arabidopsis/auxiliar/arabidopsis_thaliana.png" width="100" align="middle">  &copy; 2015 - Sistema desarrollado por <strong>Oro Verde Digital SRL</strong>

</div> 
<!--[if lt IE 8]>
<script src="http://ie7-js.googlecode.com/svn/trunk/lib/IE8.js" type="text/javascript"></script>
<![endif]-->
<script src="js/jquery.eventCalendar.js" type="text/javascript"></script>
 

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $("a[rel^='prettyPhoto']").prettyPhoto();
    });
    $('.formulario').click(function () {
        var tabla = $(this).val();
        window.open("formulario_nuevo_ajax.php?tabla=" + tabla, "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=600");
    });
    $('.wizard').click(function () {
        var tabla = $(this).val();
        window.open("formulario_nuevo_ajax.php?tabla=" + tabla + "&apertura=wizard", "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=600");
    });
    
    $('.tabla_empresa_id').hide();
        //Se configura que todos lo campos de textos se escriben en mayusculas.
    $('input').on('keyup', function () {
        $(this).val($(this).val().toUpperCase());
    });
    $('textarea').on('keyup', function () {
        $(this).val($(this).val().toUpperCase());
    })
</script>
</div>
</body>
</html>