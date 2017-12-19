<?php
include("scaffold.php");
include_once('html_sup_min.php'); 
?>
<h3>Paso 1 - Nuevo</h3>
<hr>
<form action="#" name="orden" method="POST"  autocomplete="off" width='80%'>
    <table class="table table-bordered table-striped">
        <tr>
            <td align="right" valign="top" width="150">
                Elija Pais:
            </td>
            <td>
                <select class="js-example-basic-single" name="pais_id" id="pais_id"> 
                    <option selected value=''>Elija un Pais</option>  <!--pone valor por defecto-->
                    <?php
                    $sql = "SELECT id, descripcion
                    FROM paiss
                    ORDER BY descripcion";
                    $query = mysql_query($sql);
                    while ($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
                        echo "<option value='$result_query[0]'>$result_query[1]</option\n>"; //muestra resultado de la consulta
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" width="150">
                Seleccione la Provincia: 
            </td>

            <td>
                <select class="js-example-basic-single" name="provincia_id" id="provincia_id"> 
                    <option selected value=''>Seleccione la Provincia</option>  <!--pone valor por defecto-->
                    <?php
                    $sql = "SELECT id, descripcion
                    FROM provincias
                    WHERE pais_id = '$pais_id' 
                    ORDER BY descripcion";
                    $query = mysql_query($sql);
                    while ($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
                        echo "<option value='$result_query[0]'>$result_query[0] - $result_query[1], $result_query[2]</option\n>"; //muestra resultado de la consulta
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right" valign="top" width="150">

            </td>
            <td align="center">
                <input type="submit" value="aceptar" id="aceptar"></td>
        </tr>
    </table>
</form>
<br><br><br><br><br><br><br><br>

<script>
    $('#pais_id').change(function () {
        var id = $(this).val();

        $.post('reporte_get_provincia.php', {id: id}, function (data) {
            $('#provincia_id').html(data);
        }, "html");
        $('#provincia_id').attr('disabled', false);
    })
    
    $('#aceptar').click(function(){
        var id= $('#provincia_id').val();
        window.opener.llenar_localidad(id);
        window.close();
    })
        
    
       

</script>

