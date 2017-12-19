<?php
$tip = '';

include_once('html_sup.php');
include("scaffold.php");
include 'descargar_pais.php';
$tabla_scaffold = $_POST['tabla_scaffold'];
 
$submit = $_POST['submit'];

function NombreTabla($field) {
        $field = strtoupper(substr($field,0,-1));
        $field = ucwords(str_replace('_', ' ', $field));
        return $field;
}

$tabla_nombre = NombreTabla($tabla_scaffold);


?>
<h3>Paso 2 - Nuevo <?php echo $tabla_nombre;?></h3>
<hr>

<?php


if ($submit == 'Siguiente -->') {
    $pais_id = $_POST['pais_id'];
} else {
   $clave=$_POST['pais_id'];
   $sql="update countries set activo=0 where alpha2='$clave'";

   $nombre_pais=  DevuelveValor($clave, 'langES', 'countries', 'alpha2');
   $sql_insert_pais="INSERT INTO `paiss` ("
                    . "`descripcion`,"
                    . "`usuario_id`,"
                    . "`empresa_id`"
                    . ") VALUES ("
                    . "'$nombre_pais',"
                    . "1,"
                    . "1)";
   mysql_query($sql);
   mysql_query($sql_insert_pais);
   $pais_id =mysql_insert_id();
   nuevo_pais($clave,$pais_id);

}
?>
<form action="<?php echo $tabla_scaffold;?>_nuevo.php" name="orden" method="POST"  autocomplete="off">
    Seleccione el Provincia: 
    <select class="js-example-basic-single" name="provincia_id" id="provincia_id"> 
        <option selected value=''>Seleccione la Provincia</option>  <!--pone valor por defecto-->
        <?php
        $sql = "SELECT id, descripcion
                    FROM provincias
                    WHERE pais_id = '$pais_id' 
                    ORDER BY descripcion";
        $query = mysql_query($sql);
        while ($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
            echo "<option value='$result_query[0]'>$result_query[0] - ".Scaffold::quitar_tildes($result_query[1])."</option\n>"; //muestra resultado de la consulta
        ?>
    </select>
    <input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>"/>
    <input type="hidden" name="tabla_scaffold" value="<?php echo $tabla_scaffold;?>">
    <input type="submit" value="Siguiente -->" name="submit">
</form>

<?php
include_once('html_inf.php');