<?php

include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
$funcion = $_POST['funcion'];

switch ($funcion) {
    case 'obtener_total':
        $producto_id = $_POST['producto'];
        $sql = "SELECT SUM(disponibles) FROM stocks WHERE producto_id=" . $producto_id;
        $resultado = mysql_query($sql);
        $disponibles = mysql_fetch_row($resultado);
        echo $disponibles[0];
        break;
    case 'dar_baja':
        $producto_id = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $motivo = $_POST['motivo'];
        echo $sql = "SELECT id, disponibles FROM stocks WHERE producto_id='" . $producto_id . "' and disponibles>0 ORDER BY id ASC";
        echo "<br>";
        $datos = mysql_query($sql);
        while ($row = mysql_fetch_array($datos)) {
            if ($row[1] >= $cantidad) {
                $nuevo_stock = $row[1] - $cantidad;
                $cantidad = 0;
            } else {
                $cantidad-=$row[1];
                $nuevo_stock = 0;
            }
            $sql_nuevo_stock = "UPDATE stocks SET disponibles='" . $nuevo_stock . "' WHERE id=" . $row[0];
            mysql_query($sql_nuevo_stock);
            if ($cantidad === 0) {
                break;
            }
        }
        $motivo.=" /TOTAL " . $_POST['cantidad'];
        $id = DevuelveValor('BAJA STOCK', 'id', 'estados', 'descripcion');
        echo $sql_maquina = "INSERT INTO `registro_de_estados` (`id`, `descripcion`, `tabla`, `registro_id`, `fecha_cambio_estado`, `estado_id`, `usuario_id`, `empresa_id`) "
        . "VALUES (NULL, '" . $motivo . "', 'stocks', '" . $row[0] . "', CURDATE(), $id, '1', '1');";
        mysql_query($sql_maquina);
        break;
}