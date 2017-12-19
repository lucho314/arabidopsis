<?php
if (isset($_GET['usuario_id'])) {
    $id = $_GET['usuario_id'];
    $sql_get_usuario = "SELECT * FROM usuarios where id=$id";
    $usuario = mysql_query($sql_get_usuario);
    while ($row2 = mysql_fetch_assoc($usuario)) {
        $list_usuario = $row2;
    }
    foreach ($list_usuario as $key => $value) {
        $$key = $value;
    }
}
?>
<div class="panel panel-primary" id="formulario_datos" style="display:block">
    <div class="panel-heading">
        <h3 class="panel-title">Formulario de carga de datos: <strong>Usuarios</strong></h3>
    </div>
    <div class="panel-body">
        <form action="" id="datos_usuario_<?= $_GET['ban'] ?>" >
            <table id="scaffold" class="table table-bordered table-striped" cellpadding="2" cellspacing="0" border="0" width="80%">

                <tr>
                    <td align="right"  valign="top" width="155"><b>Nombre:</b></td>
                    <td><input type="text" name="nombre" id="usuario" class="mayuscula" size="35" required="true" value="<?= $nombre ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155"><b>Apellido:</b></td>
                    <td><input type="text" name="apellido"  class="mayuscula"  id="usuario" size="35" required="true" value="<?= $apellido ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155"><b>Usuario:</b></td>
                    <td><input type="text"    name="usuario" id="usuario" size="35" required="true" value="<?= $usuario ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155"><b>Telefono:</b></td>
                    <td><input type="tel" name="telefono" id="usuario" size="35" value="<?= $telefono ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155"><b>Email:</b></td>
                    <td><input type="email" name="email" id="usuario" size="35" required="true" value="<?= $email ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155" size="35"><b>Domicilio:</b></td>
                    <td><input type="text" class="mayuscula"  name="domicilio" id="usuario" size="35" required="true" value="<?= $domicilio ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155"><b>Localidad:</b></td>
                    <td><input type="text"  class="mayuscula" name="localidad" id="usuario" size="35" required="true" value="<?= $localidad ?>"></td>
                </tr>
                <tr>
                    <td align="right"  valign="top" width="155"><b>Provincia:</b></td>
                    <td><input type="text" class="mayuscula" name="provincia" id="usuario" size="35" required="true" value="<?= $provincia ?>"></td>
                </tr>
                <?php if (!isset($_GET['usuario_id'])): ?>
                    <tr>
                        <td align="right"  valign="top" width="155"><b>Contrase&ntilde;a:</b></td>
                        <td><input type="password" name="pass" id="pass" size="35" required="true"></td>
                    </tr>
                    <tr>
                        <td align="right"  valign="top" width="155" ><b>Repetir contrase&ntilde;a:</b></td>
                        <td id="tabla_rpas"><input type="password" name="rep_pass" id="rep_pass" size="35" required="true"></td>
                    </tr>
                <?php else: ?>

                    <input type="hidden" id="id_usuario" value="<?= $_GET['usuario_id'] ?>" name="id">
                <?php endif; ?>

                <tr>
                    <td align="right"  valign="top" width="155"></td>
                    <td><input type="submit" name="aceptar" id="aceptar" value="aceptar" size="35" required="true"></td>
                </tr>

            </table>
        </form>

    </div>
</div>
