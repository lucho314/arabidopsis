<?php
$tip = '';
include_once('html_sup.php');
//include("scaffold.php");
?>
 
<form action="nueva_orden_paso_2.php" name="orden" method="POST"  autocomplete="off">
    Elija ciudad: 
    <select class="js-example-basic-single" name="cliente_id" id="cliente_id"> 
        <option selected value=''>Elija un </option>  <!--pone valor por defecto-->
        <?php
         $provincia_id = $_POST['provincia_id'];

        $sql = "SELECT id, descripcion FROM localidads WHERE provincia_id='$provincia_id'  ORDER BY descripcion";
        
        $query = mysql_query($sql);
        while ($result_query = mysql_fetch_array($query))//recorre el array donde guarde consulta
            echo "<option value='$result_query[0]'>".quitar_tildes($result_query[1])."</option\n>"; //
        ?>
    </select>
    <input type="submit" value="Siguiente -->" name="submit">
</form>
<?= $sql?>

<?php
include_once('html_inf.php');