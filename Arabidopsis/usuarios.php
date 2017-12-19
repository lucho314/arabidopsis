<?php
include_once('html_sup.php');
include("scaffold.php");
$sql = "SELECT "
        . "usuario,"
        . "telefono,"
        . "domicilio,"
        . "localidad,id"
        . " FROM usuarios "
        . "WHERE descripcion NOT LIKE '%colaborador%'";

$datos = mysql_query($sql);
$total = mysql_query("SELECT COUNT(*) FROM usuarios WHERE descripcion NOT LIKE '%colaborador%'");
$total = mysql_fetch_array($total);

// Inicializo las variables

$aceptar_modulos_nuevo  = $_POST['aceptar_modulos_nuevo'];
$aceptar_modulos_editar = $_POST['aceptar_modulos_editar'];
$modulos_activos        = $_POST['modulos_activos'];
$modulos                = $_POST['modulos'];
$usuario_id             = $_POST['usuario_id'];
$activos                = array();
$nuevos                 = array();

//Si existe aceptar_modulos_nuevo se registran los modulos para ese usuario 
if (isset($aceptar_modulos_nuevo)) {
    foreach ($modulos as $modulos_id) {

        $sql_insert_modulos = "INSERT INTO `usuario_modulos` ("
                . "`id`, "
                . "`descripcion`, "
                . "`modulo_id`, "
                . "`usuario_id`, "
                . "`empresa_id`"
                . ") VALUES ("
                . "NULL, "
                . "'" . $modulos_id . "-" . $usuario_id . "'"
                . ",'$modulos_id',"
                . "'" . $_POST['usuario_id'] . "',"
                . " 1"
                . ");";
        
        
        mysql_query($sql_insert_modulos) or die("No se pudieron agregar los m&oacute;dulos");
    }
}




//si existe aceptar_modulos_editar se procede a editar los modulos que tiene activo el usuario.
if (isset($aceptar_modulos_editar)) {
    
    $activos = unserialize($modulos_activos);
    echo "Modulos activos: ".$activos."<br>";
    
    $nuevos  = $modulos;
    
    echo "Modulos nuevos: ".$nuevos."<br>";
    
    if (count($nuevos) > count($activos)) {
        
        //Comparo $nuevos con $activos y devuelvo los valores de $nuevos 
        //que no estén presentes en $activos. Si $activos esta vacio, 
        //me va a insertar solo los nuevos.
        
        $insertar = array_diff($nuevos, $activos);  
        
        foreach ($insertar as $modulos_id) {
            $sql_insert = "INSERT INTO `usuario_modulos` ("
                            . "`id`, "
                            . "`descripcion`, "
                            . "`modulo_id`, "
                            . "`usuario_id`, "
                            . "`empresa_id`"
                       . ") VALUES ("
                            . "NULL, "
                            . "'" . $modulos_id . "-" . $_POST['usuario_id'] . "',"
                            . "'$modulos_id',"
                            . "'" . $_POST['usuario_id'] . "',"
                            . " 1);";
            
            mysql_query($sql_insert) or die("No se pudieron agregar los m&oacute;dulos");
        }
    }
    if (count($nuevos) < count($activos)) {
        $sacar = array_diff($activos, $nuevos);
        foreach ($sacar as $modulos_id) {
            $sql_delete = "DELETE FROM `usuario_modulos` WHERE modulo_id=$modulos_id and usuario_id=" . $_POST['usuario_id'];
            mysql_query($sql_delete);
        }
    }
}


//consulta para traer los datos del usuario a modificar
?>



<!-- EL SIGUIENTE SCRIPT SIRVE PARA GENERAR EL CAMPO DESCRIPCION EN CASO DE QUE SE PASE AL SCAFFOLD LA OPCION "noeditable". SI EN VEZ DE ESTO SE PASA LA OPCION "editable" EL SCRIPT DEBE COMENTARSE. SI LA TABLA NO TIENE CAMPO DESCRIPCION ENTONCES DEBE MARCARSE COMO "noeditable" -->

<!--<script type="text/javascript">
function creardescripcion() {

    costoinst=document.getElementById('costoinst').value;
    costoent=document.getElementById('costoent').value;

    descripcion=costoinst+' '+costoent;

    document.getElementById('descripcion').value=descripcion;
    document.forms.crear.submit();
}
</script>-->
<!-- La bandera nuevo sirve para mostrar el formulario para crear nuevo usuario. De lo contrario se listan los usuarios -->
<?php if (isset($_GET['ban'])): ?>
    <div class="botonera">  
        <div class="form-inline"><input type="button" class="btn btn-success" value="Datos Usuario" onclick="datos()" id="btn-datos">

            <input type="button" class="btn btn-default" value="Asignar modulos" id="btn-modulos" onclick="modulos()"></div>
    </div>


    <?php
    include_once 'form_nuevo_usuario.php';
    include_once 'form_modulos_usuario.php';
else:
    ?>
    <br>
    <?= $total[0] ?> Registro/s encontrado/s.<br> Secci&oacute;n: <strong>Usuarios</strong>. |
    <br> <a href="usuarios.php?ban=nuevo">Registro nuevo</a>
    <br><br>
    <table class="table table-striped" id="lista" cellpadding="2" cellspacing="0" border="0">
        <thead>
            <tr>
                <td align=\"center\"><b>Usuario</b></td>
                <td align=\"center\"><b>Telefono</b></td>
                <td align=\"center\"><b>Domicilio</b></td>
                <td align=\"center\"><b>Localidad</b></td>
                <td align=\"center\"><b>Editar?</b></td>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysql_fetch_array($datos)) : ?>
                <tr>
                    <td><?= $row[0] ?></td>
                    <td><?= $row[1] ?></td>
                    <td><?= $row[2] ?></td>
                    <td><?= $row[3] ?></td>
                    <td><a href="usuarios.php?ban=editar&usuario_id=<?= $row[4] ?>">Editar?</a></td>
                </tr>

            <?php endwhile; ?>
        </tbody>
    </table>




<?php
endif;
include_once('html_inf.php');
?>
<style>
    .botonera{
        margin-left: -72%;
    }
</style>
<script type='text/javascript' src='libjs/usuarios.js'></script>