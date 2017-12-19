<?php
$tip='Es recomendable que periodicamente Exporte los cambios de los usuarios a excel para liberar espacio.';
include_once('html_sup.php');
include("scaffold.php");
if (isset($_GET['usuario_id']) && is_numeric($_GET['usuario_id'])) {
    $usuario_id = $_GET['usuario_id'];
} else {
    $usuario_id = $_SESSION['usuario_id'];
}
$sql_usuarios = "SELECT id, descripcion FROM usuarios where descripcion NOT LIKE '%colaborador%'";
$list_usuario = mysql_query($sql_usuarios);
$sql = "SELECT fecha_cambio_estado,registro_de_estados.descripcion,tabla,estados.descripcion "
        . "from registro_de_estados "
        . "inner join estados on estados.id=registro_de_estados.estado_id "
        . "where registro_de_estados.usuario_id=$usuario_id";
$total = mysql_query("select count(*) FROM registro_de_estados where registro_de_estados.usuario_id=$usuario_id");
$total = mysql_fetch_array($total);
$cambios = mysql_query($sql);
$nombre_usuario=  DevuelveValor($usuario_id, 'usuario', 'usuarios', 'id');
$fecha=date('d-m-y');
?>
<font style="font-size: 25px">Selecione Usuario:</font><select class="js-example-basic-single" id="usuario" value="<?= $usuario_id ?>">
    <?php
    while ($usuario = mysql_fetch_array($list_usuario)) {
        $select.= "<option value='" . $usuario[0] . "' ";
        $select.= ($usuario[0] === $usuario_id) ? 'selected' : '';
        $select.= ">" . $usuario[1] . "</option>";
    }
    echo $select;
    ?>
</select>
<br>
<br>
<?= $total[0] ?> Registro/s encontrado/s.<br> Secci&oacute;n: <strong>Historial de cambios</strong>. |
<table class="table table-striped" id="lista" cellpadding="2" cellspacing="0" border="0">
    <thead>
        <tr>
            <td align=\"center\"><b>Fecha cambio</b></td>
            <td align=\"center\"><b>Descripcion</b></td>
            <td align=\"center\"><b>Tabla</b></td>
            <td align=\"center\"><b>Cambio</b></td>
        </tr>
    </thead>
    <?php while ($row = mysql_fetch_array($cambios)): ?>

        <tr>
            <td><?= $row[0] ?></td>
            <td><?= $row[1] ?></td>
            <td><?= $row[2] ?></td>
            <td><?= $row[3] ?></td>
        </tr>
        <?php
    endwhile;
    ?>
    <tbody>
    </tbody>
</table>
<?php
include_once('html_inf.php');
?>
<script>
    $(function () {
        $('#lista').DataTable({
            "bFilter": false,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: 'Exportar a Exel y Limpiar',
                    filename: 'cambios_usuario_<?= $nombre_usuario.'_'.$fecha?>',
                    customize: function ( ) {
                        var r = confirm("Esta accion exporta los cambios de este usuario a excel y elimina los registros de la base de datos. Realizar esta accion para liberar espacio");
                        if (r == true) {
                            limpiar(<?= $usuario_id ?>)
                        } else {
                            stopPropagation();
                        }

                    }}

            ],
            "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            }
        });
    });
    $('#usuario').change(function () {
        id = $(this).val();
        window.location.href = 'cambios.php?usuario_id=' + id;
    });


    function limpiar(id)
    {
        $.post('ajax_liberar_cambios.php', {id: id}, function () {
            

        }, "json");
        setTimeout ("location.reload();", 1000); 
    }
</script>
