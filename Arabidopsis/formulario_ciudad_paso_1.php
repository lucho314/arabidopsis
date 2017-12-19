<?php
$tip = '';
include_once('html_sup.php');
include("scaffold.php");
 
$tabla_scaffold = LimpiarXSS($_GET['tabla_scaffold']);


function NombreTabla($field) {
        $field = strtoupper(substr($field,0,-1));
        $field = ucwords(str_replace('_', ' ', $field));
        return $field;
}

$tabla_nombre = NombreTabla($tabla_scaffold);        
?>
<head>
    <link rel="stylesheet" href="css/caja_modal.css">
</head>
<h3>Paso 1 - Nuevo <?php echo $tabla_nombre;?></h3>
<hr>
<form action="formulario_ciudad_paso_2.php" name="orden" method="POST"  autocomplete="off">
    Elija Pais: 
    <select class="js-example-basic-single" name="pais_id" id="pais_id"> 
        <option selected value=''>Elija un Pa&iacute;s</option>  <!--pone valor por defecto-->
        <?php
        $sql = "SELECT id, descripcion
                    FROM paiss
                    ORDER BY descripcion";
        $query = mysql_query($sql);
        while ($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
            echo "<option value='$result_query[0]'>".Scaffold::quitar_tildes($result_query[1])."</option\n>"; //muestra resultado de la consulta
        ?>
    </select>
    <input type="hidden" name="tabla_scaffold" value="<?php echo $tabla_scaffold; ?>">
    <input type="submit" value="Siguiente -->" name="submit">
</form>
<hr>
O cargue un nuevo Pa&iacute;s:
<br>

          <div class="panel panel-danger">
            <div class="panel-heading">
              <h3 class="panel-title">Formulario de carga de datos: <strong>Pa&iacute;s</strong></h3>
            </div>
<br>
<form action="formulario_ciudad_paso_2.php" method="POST" name="crear" id="crear" enctype="multipart/form-data"><input type="hidden" name="variablecontrolposnavegacion" value="create">
    <table cellpadding="2" cellspacing="0" border="0" width="700">
        <tr>
        <input type="hidden" name="descripcion" id="descripcion" />
        <tr>
            <td align="right"  width="300">
                <strong>Elija Nuevo Pa&iacute;s: </strong>
            </td>
            <td>
                <select class="js-example-basic-single" name="pais_id" id="pais"> 
                    <option selected value='' size="50">Elija un Pa&iacute;s</option>  <!--pone valor por defecto-->
                    <?php
                    $sql = "SELECT alpha2,langES
                    FROM countries
                    WHERE activo=1
                    ORDER BY langES";
                    $query = mysql_query($sql);
                    while ($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
                        echo "<option value='$result_query[0]'>$result_query[0] - ".  Scaffold::quitar_tildes($result_query[1])."</option\n>"; //muestra resultado de la consulta
                    ?>
                </select>
            </td>
            <td>  
                    <input type="hidden" name="tabla_scaffold" value="<?php echo $tabla_scaffold; ?>">
                    <button type="button" id="cargar" class="btn btn-default" data-dismiss="modal">Agregar Registro</button>
                    
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
        </tr>
    </table>

</form>
           
</div>
<a href="#openModal" id="link" style="display:none;"></a>
<div id="openModal" class="modalDialog">
    <div>
        <!--<a href="#close" title="Close" class="close">X</a>-->
        <h2>Se est&aacute;n agregando los datos a la base de datos.</h2>
        <p>Por favor, espere mientras se finaliza el procedimiento.</p>
        <img src="img/cargando.gif" style="margin:0px auto;display:block"/>
    </div>
</div>



<br><br><br><br><br><br><br><br>


<?php
include_once('html_inf.php');
?>
<script>
    //$(document).ready(function () {
        $('#cargar').click(function () {
                window.location = document.getElementById('link').href;
                $('#crear').submit();
        });
    

</script> 