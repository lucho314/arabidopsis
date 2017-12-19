<?php

$id=$_GET['usuario_id'];

 $sql_modulos = "SELECT DISTINCT modulos.id, modulos.descripcion, (IF( t1.id is null, '', 'checked' )) "
        . "FROM modulos LEFT JOIN (SELECT id, usuario_modulos.modulo_id FROM usuario_modulos "
        . "WHERE usuario_modulos.usuario_id='$id') as t1 on t1.modulo_id=modulos.id";
 echo $sql_modulos;
$modulos = mysql_query($sql_modulos);
?>

<div class="panel panel-primary" id="formulario_modulos" style="display:none">
    <div class="panel-heading">
        <h3 class="panel-title">Asignacion de modulos</h3>
    </div>
    <div class="panel-body"></div>
    <form action="usuarios.php" id="modulos_usuario" method="post">
        <table id="scaffold" class="table table-bordered table-striped" cellpadding="2" cellspacing="0" border="0" width="80%">
            <?php
            $i = 0;
            while ($row1 = mysql_fetch_array($modulos)):
                if($row1[2]==='checked'){
                    $activos[]=$row1[0];
                }         
                ?>
                <?php if ($i % 2 == 0) echo "<tr>" ?>

                <td align="right"  valign="top" width="255"><b><?= $row1[1] ?>:</b></td>
                <td align="left"  valign="top" width="255"><input type="checkbox" class="modulos" name="modulos[]" value="<?= $row1[0] ?>" <?= $row1[2] ?>/></td>
               
                <?php if ($i % 2 == 2) echo "</tr>" ?> 
                <?php
                $i++;
            endwhile;
            ?>
            <input type="hidden" name="usuario_id" id="usuario_id">
            <input type="hidden" name="modulos_activos" value='<?= serialize($activos)?>'>
            <tr>
                <td align="center" colspan="4"><input type="submit" name="aceptar_modulos_<?= $_GET['ban'] ?>" id="aceptar" value="aceptar" size="35"></td>
            </tr>
        </table>
            </div>
